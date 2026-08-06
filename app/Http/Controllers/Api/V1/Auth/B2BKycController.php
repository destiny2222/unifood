<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kyc;
use App\Models\Admin;
use App\Notifications\B2BApplicationSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class B2BKycController extends Controller
{
    /**
     * Submit KYC details for a B2B trade account.
     */
    public function submitKyc(Request $request)
    {
        $user = $request->user();



        if ($user->kyc()->exists()) {
            return response()->json([
                'error' => 'You are already associated with a B2B trade account.'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'company_registration_number' => ['required', 'string', 'regex:/^[A-Z0-9\-\s]{5,20}$/i'],
            'business_type' => 'required|string|in:restaurant,retailer,caterer,reseller,other',
            'trade_address' => 'required|string',
            'billing_contact' => 'required|string|max:255',
            'estimated_monthly_order_volume' => 'required|string|max:255',
        ], [
            'company_registration_number.regex' => 'The company/VAT number format is invalid. It should be alphanumeric, between 5 and 20 characters.',
        ]);


        try {
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
        DB::beginTransaction();
            // Create the KYC record
            $kyc = Kyc::create([
                'user_id' => $user->id,
                'company_name' => $request->company_name,
                'company_registration_number' => $request->company_registration_number,
                'business_type' => $request->business_type,
                'trade_address' => $request->trade_address,
                'billing_contact' => $request->billing_contact,
                'estimated_monthly_order_volume' => $request->estimated_monthly_order_volume,
                'status' => 'pending',
            ]);

            // Link user to KYC record, set as owner, and set view to business
            $user->update([
                'is_business_owner' => true,
                'current_view' => 'business',
            ]);

            // Send internal notification to Mightyolu sales/admin team
            try {
                $admins = Admin::all();
                if ($admins->count() > 0) {
                    Notification::send($admins, new B2BApplicationSubmitted($kyc));
                }
            } catch (\Exception $e) {
                logger()->error('Failed to notify admins of B2B KYC submission: ' . $e->getMessage());
            }

            DB::commit();
            return response()->json([
                'message' => 'Your application has been received and is pending review.',
                'data' => $kyc,
                // 'data' => $user->fresh()->load('kyc'),
            ], 201);
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error submitting KYC: " . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while submitting KYC.',
            ], 500);
        }
    }

    /**
     * Get the authenticated user's profile and KYC details.
     */
    public function profile(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'data' => $user->fresh()->load('kyc'),
        ]);
    }

    /**
     * Update the business details for an approved trade account.
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        if (!$user->kyc || $user->kyc->status !== 'approved') {
            return response()->json([
                'error' => 'Only approved business accounts can update details.'
            ], 403);
        }

        if (!$user->is_business_owner) {
            return response()->json([
                'error' => 'Only the business owner can update company details.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'trade_address' => 'required|string',
            'billing_contact' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->kyc->update([
            'company_name' => $request->company_name,
            'trade_address' => $request->trade_address,
            'billing_contact' => $request->billing_contact,
        ]);

        return response()->json([
            'message' => 'Business details updated successfully.',
            'kyc' => $user->kyc->fresh(),
        ]);
    }

    /**
     * Toggle the current view mode between personal and business.
     */
    public function switchView(Request $request)
    {
        $user = $request->user();

        if (!$user->kyc()->exists()) {
            return response()->json([
                'error' => 'You do not have a B2B business account associated.'
            ], 400);
        }

        $newView = $user->current_view === 'business' ? 'personal' : 'business';
        $user->update([
            'current_view' => $newView,
        ]);

        return response()->json([
            'message' => "Switched view to {$newView} mode successfully.",
            'current_view' => $newView,
            'data' => $user->load('kyc'),
        ]);
    }

    /**
     * Resubmit a rejected or info-requested B2B KYC application.
     */
    public function resubmit(Request $request)
    {
        $user = $request->user();

        if (!$user->kyc) {
            return response()->json(['error' => 'No KYC application found.'], 404);
        }

        $kyc = $user->kyc;

        if (!in_array($kyc->status, ['rejected', 'info_requested'])) {
            return response()->json(['error' => 'You can only resubmit applications that are rejected or require more info.'], 400);
        }

        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'company_registration_number' => ['required', 'string', 'regex:/^[A-Z0-9\-\s]{5,20}$/i'],
            'business_type' => 'required|string|in:restaurant,retailer,caterer,reseller,other',
            'trade_address' => 'required|string',
            'billing_contact' => 'required|string|max:255',
            'estimated_monthly_order_volume' => 'required|string|max:255',
        ], [
            'company_registration_number.regex' => 'The company/VAT number format is invalid. It should be alphanumeric, between 5 and 20 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $kyc->update([
            'company_name' => $request->company_name,
            'company_registration_number' => $request->company_registration_number,
            'business_type' => $request->business_type,
            'trade_address' => $request->trade_address,
            'billing_contact' => $request->billing_contact,
            'estimated_monthly_order_volume' => $request->estimated_monthly_order_volume,
            'status' => 'pending',
            'status_notes' => null,
        ]);

        // Send internal notification to Mightyolu sales/admin team
        try {
            $admins = Admin::all();
            if ($admins->count() > 0) {
                Notification::send($admins, new B2BApplicationSubmitted($kyc));
            }
        } catch (\Exception $e) {
            logger()->error('Failed to notify admins of B2B resubmission: ' . $e->getMessage());
        }

        return response()->json([
            'message' => 'Your application has been successfully updated and resubmitted for review.',
            'kyc' => $kyc->fresh(),
        ]);
    }

    /**
     * Get all authorized buyers registered under the same KYC account.
     */
    public function getAuthorizedBuyers(Request $request)
    {
        return response()->json(['error' => 'Authorized buyers feature is disabled in this configuration.'], 403);
    }

    /**
     * Add a new authorized buyer under the same B2B business account.
     */
    public function addAuthorizedBuyer(Request $request)
    {
        return response()->json(['error' => 'Authorized buyers feature is disabled in this configuration.'], 403);
    }
}

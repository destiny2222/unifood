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
use App\Traits\CloudinaryUploadTrait;

class B2BKycController extends Controller
{
    use CloudinaryUploadTrait;

    /**
     * Helper method to validate and extract KYC input data for all 6 sections.
     */
    protected function prepareKycData(Request $request, ?Kyc $existingKyc = null): array
    {
        $input = $request->all();

        // 1. Determine company_name / registered_business_name
        $companyName = $input['registered_business_name'] ?? $input['company_name'] ?? null;

        // 2. Determine trade_address from individual components if not explicitly provided
        $tradeAddress = $input['trade_address'] ?? null;
        if (!$tradeAddress && !empty($input['address_line_1'])) {
            $parts = array_filter([
                $input['address_line_1'] ?? null,
                $input['address_line_2'] ?? null,
                $input['city'] ?? null,
                $input['postcode'] ?? null,
                $input['country'] ?? null,
            ]);
            $tradeAddress = implode(', ', $parts);
        }

        // 3. Determine billing_contact from primary contact details if not explicitly provided
        $billingContact = $input['billing_contact'] ?? null;
        if (!$billingContact && !empty($input['primary_contact_name'])) {
            $contactParts = array_filter([
                $input['primary_contact_name'] ?? null,
                $input['primary_contact_position'] ? "({$input['primary_contact_position']})" : null,
                $input['primary_contact_email'] ?? null,
                $input['primary_contact_phone'] ?? null,
            ]);
            $billingContact = implode(' - ', $contactParts);
        }

        // 4. Determine estimated_monthly_order_volume
        $monthlyVolume = $input['estimated_monthly_purchase_value'] ?? $input['estimated_monthly_order_volume'] ?? null;

        // 5. Handle document file uploads for Section 5 (Cloudinary with local fallback)
        $documentFields = [
            'certificate_of_incorporation',
            'proof_of_business_address',
            'vat_registration_certificate',
            'business_bank_statement',
            'government_id',
            'proof_of_residential_address',
            'partnership_agreement',
            'sole_trader_evidence',
        ];

        $documents = [];
        foreach ($documentFields as $field) {
            if ($request->hasFile($field)) {
                $cloudResult = $this->uploadDocumentToCloudinary($request->file($field), 'mightyolu/kyc_documents');
                if (!empty($cloudResult['success']) && !empty($cloudResult['secure_url'])) {
                    $documents[$field] = $cloudResult['secure_url'];
                } else {
                    $documents[$field] = $request->file($field)->store('kyc_documents', 'public');
                }
            } elseif ($request->filled($field) && is_string($request->input($field))) {
                $documents[$field] = $request->input($field);
            } elseif ($existingKyc && isset($existingKyc->$field)) {
                $documents[$field] = $existingKyc->$field;
            }
        }

        // Handle other_documents (multiple optional uploads or JSON)
        $otherDocs = [];
        if ($request->hasFile('other_documents')) {
            $files = is_array($request->file('other_documents')) ? $request->file('other_documents') : [$request->file('other_documents')];
            foreach ($files as $file) {
                $cloudResult = $this->uploadDocumentToCloudinary($file, 'mightyolu/kyc_documents');
                if (!empty($cloudResult['success']) && !empty($cloudResult['secure_url'])) {
                    $otherDocs[] = $cloudResult['secure_url'];
                } else {
                    $otherDocs[] = $file->store('kyc_documents', 'public');
                }
            }
        } elseif ($request->filled('other_documents')) {
            $otherDocs = is_array($request->input('other_documents'))
                ? $request->input('other_documents')
                : [$request->input('other_documents')];
        } elseif ($existingKyc && $existingKyc->other_documents) {
            $otherDocs = $existingKyc->other_documents;
        }

        return [
            'company_name' => $companyName,
            'trading_name' => $input['trading_name'] ?? null,
            'business_type' => strtolower($input['business_type'] ?? 'other'),
            'company_registration_number' => $input['company_registration_number'] ?? null,
            'vat_registration_number' => $input['vat_registration_number'] ?? null,
            'date_business_established' => $input['date_business_established'] ?? null,
            'nature_of_business' => $input['nature_of_business'] ?? null,
            'business_website' => $input['business_website'] ?? null,

            'trade_address' => $tradeAddress,
            'address_line_1' => $input['address_line_1'] ?? null,
            'address_line_2' => $input['address_line_2'] ?? null,
            'city' => $input['city'] ?? null,
            'postcode' => $input['postcode'] ?? null,
            'country' => $input['country'] ?? null,

            'billing_contact' => $billingContact,
            'primary_contact_name' => $input['primary_contact_name'] ?? null,
            'primary_contact_position' => $input['primary_contact_position'] ?? null,
            'primary_contact_email' => $input['primary_contact_email'] ?? null,
            'primary_contact_phone' => $input['primary_contact_phone'] ?? null,
            'preferred_contact_method' => $input['preferred_contact_method'] ?? 'email',

            'owner_full_name' => $input['owner_full_name'] ?? null,
            'owner_position' => $input['owner_position'] ?? null,
            'owner_nationality' => $input['owner_nationality'] ?? null,
            'owner_dob' => $input['owner_dob'] ?? null,
            'owner_residential_address' => $input['owner_residential_address'] ?? null,

            'certificate_of_incorporation' => $documents['certificate_of_incorporation'] ?? null,
            'proof_of_business_address' => $documents['proof_of_business_address'] ?? null,
            'vat_registration_certificate' => $documents['vat_registration_certificate'] ?? null,
            'business_bank_statement' => $documents['business_bank_statement'] ?? null,
            'government_id' => $documents['government_id'] ?? null,
            'proof_of_residential_address' => $documents['proof_of_residential_address'] ?? null,
            'partnership_agreement' => $documents['partnership_agreement'] ?? null,
            'sole_trader_evidence' => $documents['sole_trader_evidence'] ?? null,
            'other_documents' => !empty($otherDocs) ? $otherDocs : null,

            'primary_products_of_interest' => $input['primary_products_of_interest'] ?? null,
            'estimated_monthly_order_volume' => $monthlyVolume,
            'expected_order_frequency' => $input['expected_order_frequency'] ?? null,
            'purpose_of_purchase' => $input['purpose_of_purchase'] ?? null,
        ];
    }

    /**
     * Get validation rules for KYC submission.
     */
    protected function getKycValidationRules(Request $request): array
    {
        $regNumRules = ['nullable', 'string'];
        if ($request->filled('company_registration_number')) {
            $regNumRules[] = 'regex:/^[A-Z0-9\-\s]{5,20}$/i';
        }

        return [
            'company_name' => 'required_without:registered_business_name|nullable|string|max:255',
            'registered_business_name' => 'required_without:company_name|nullable|string|max:255',
            'trading_name' => 'nullable|string|max:255',
            'business_type' => 'required|string',
            'company_registration_number' => $regNumRules,
            'vat_registration_number' => 'nullable|string|max:255',
            'date_business_established' => 'nullable|date',
            'nature_of_business' => 'nullable|string|max:255',
            'business_website' => 'nullable|string|max:255',

            'trade_address' => 'required_without:address_line_1|nullable|string',
            'address_line_1' => 'required_without:trade_address|nullable|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postcode' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:255',

            'billing_contact' => 'required_without:primary_contact_name|nullable|string|max:255',
            'primary_contact_name' => 'required_without:billing_contact|nullable|string|max:255',
            'primary_contact_position' => 'nullable|string|max:255',
            'primary_contact_email' => 'nullable|email|max:255',
            'primary_contact_phone' => 'nullable|string|max:50',
            'preferred_contact_method' => 'nullable|string',

            'owner_full_name' => 'nullable|string|max:255',
            'owner_position' => 'nullable|string|max:255',
            'owner_nationality' => 'nullable|string|max:255',
            'owner_dob' => 'nullable|date',
            'owner_residential_address' => 'nullable|string',

            'certificate_of_incorporation' => 'nullable',
            'proof_of_business_address' => 'nullable',
            'vat_registration_certificate' => 'nullable',
            'business_bank_statement' => 'nullable',
            'government_id' => 'nullable',
            'proof_of_residential_address' => 'nullable',
            'partnership_agreement' => 'nullable',
            'sole_trader_evidence' => 'nullable',
            'other_documents' => 'nullable',

            'primary_products_of_interest' => 'nullable|string',
            'estimated_monthly_order_volume' => 'nullable|string|max:255',
            'estimated_monthly_purchase_value' => 'nullable|string|max:255',
            'expected_order_frequency' => 'nullable|string',
            'purpose_of_purchase' => 'nullable|string',
        ];
    }

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

        $validator = Validator::make($request->all(), $this->getKycValidationRules($request), [
            'company_registration_number.regex' => 'The company/VAT number format is invalid. It should be alphanumeric, between 5 and 20 characters.',
        ]);

        try {
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            DB::beginTransaction();

            $kycData = array_merge($this->prepareKycData($request), [
                'user_id' => $user->id,
                'status' => 'pending',
            ]);

            // Ensure required fallback fields exist
            if (empty($kycData['trade_address'])) {
                $kycData['trade_address'] = 'Not provided';
            }
            if (empty($kycData['billing_contact'])) {
                $kycData['billing_contact'] = $user->name . ' (' . $user->email . ')';
            }
            if (empty($kycData['estimated_monthly_order_volume'])) {
                $kycData['estimated_monthly_order_volume'] = 'Not specified';
            }

            // Create the KYC record
            $kyc = Kyc::create($kycData);

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
            'company_name' => 'nullable|string|max:255',
            'registered_business_name' => 'nullable|string|max:255',
            'trade_address' => 'nullable|string',
            'billing_contact' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $updateData = array_filter($this->prepareKycData($request, $user->kyc));
        $user->kyc->update($updateData);

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

        $validator = Validator::make($request->all(), $this->getKycValidationRules($request), [
            'company_registration_number.regex' => 'The company/VAT number format is invalid. It should be alphanumeric, between 5 and 20 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $kycData = array_merge($this->prepareKycData($request, $kyc), [
            'status' => 'pending',
            'status_notes' => null,
        ]);

        $kyc->update($kycData);

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

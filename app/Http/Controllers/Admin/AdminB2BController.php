<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kyc;
use App\Notifications\B2BApplicationStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminB2BController extends Controller
{
    /**
     * List all B2B trade account applications.
     */
    public function index()
    {
        $applications = Kyc::with('user')->orderBy('id', 'desc')->get();
        return view('admin.b2b.index', compact('applications'));
    }

    /**
     * Show details of a specific B2B trade account application.
     */
    public function show($id)
    {
        $application = Kyc::with('user')->findOrFail($id);
        return view('admin.b2b.show', compact('application'));
    }

    /**
     * Handle actions (approve, reject, request_info) on a B2B application.
     */
    public function handleAction(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|string|in:approve,reject,request_info',
            'pricing_tier' => 'required_if:action,approve|string|nullable',
            'status_notes' => 'required_if:action,reject|required_if:action,request_info|string|nullable',
        ]);

        try {
            $application = Kyc::with('user')->findOrFail($id);
            $action = $request->action;
            $user = $application->user;

            if ($action === 'approve') {
                $application->update([
                    'status' => 'approved',
                    'pricing_tier' => $request->pricing_tier,
                    'status_notes' => null,
                ]);

                // Automatically switch the owner's current view to business on approval if not set
                if ($user) {
                    $user->update([
                        'current_view' => 'business'
                    ]);
                }

                $message = 'Trade account approved and activated.';
            } elseif ($action === 'reject') {
                $application->update([
                    'status' => 'rejected',
                    'status_notes' => $request->status_notes,
                ]);
                $message = 'Trade account application rejected.';
            } else {
                $application->update([
                    'status' => 'info_requested',
                    'status_notes' => $request->status_notes,
                ]);
                $message = 'More information requested from applicant.';
            }

            // Send notification/email to the user
            if ($user) {
                try {
                    $user->notify(new B2BApplicationStatusNotification($application));
                } catch (\Exception $ex) {
                    Log::error('Failed to send B2B status email: ' . $ex->getMessage());
                }
            }

            return redirect()->route('admin.b2b.applications.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Something went wrong while processing the application.');
        }
    }
}

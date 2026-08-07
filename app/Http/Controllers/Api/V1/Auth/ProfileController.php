<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Contact;
use App\Models\Admin;

class ProfileController extends Controller
{
    // edit first name and last name and email
    public function edit(Request $request)
    {
        $user = auth()->user();
        $user->name = trim($request->first_name . ' ' . $request->last_name);
        $user->email = $request->email;
        $user->save();

        return response()->json([
            "success" => true,
            "message" => "Profile updated successfully",
            "data" => $user
        ]);
    }

    // change password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect',
            ], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully',
        ]);
    }


    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user = auth()->user();

        // Delete old avatar
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Avatar updated successfully',
            'avatar'  => asset('storage/' . $user->avatar),
        ]);
    }


    public function contactStore(Request $request)
    {
        $contact = new Contact([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ]);
        try{
            $contact->save();
            // mail administrator
            $admins = ['Olumideadelugba25@gmail.com', 'dailydevo9@gmail.com', 'mightyolultd@gmail.com'];
            foreach ($admins as $admin) {
                $email = is_object($admin) ? $admin->email : $admin;
                Mail::raw(
                    "You have received a new contact message:\n\nName: {$contact->name}\nEmail: {$contact->email}\nPhone: {$contact->phone}\nSubject: {$contact->subject}\nMessage: {$contact->message}",
                    function ($message) use ($email) {
                        $message->to($email)
                                ->subject('New Contact Message');
                    }
                );
            }
            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully!'
            ]);
        }catch(\Exception $exception){
            Log::error($exception->getMessage() . "\n" . $exception->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending the message. Please try again later.'
            ], 500);
        }
    }

}
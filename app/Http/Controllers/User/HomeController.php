<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DeliveryArea;
use App\Models\ShippingAddress;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index(){
        $user  = Auth::user();
        $wishlist = Wishlist::orderBy('id', 'desc')->get();
        $shippingAddress = ShippingAddress::where('user_id', $user->id)->get();
        $deliveryArea = DeliveryArea::orderBy('id', 'desc')->get();
        // dd($user);
        // $order = Order::where('user_id', $user->id)->get();
        // completed order
        // $completedOrder = Order::where('user_id', $user->id)->where('order_status', 'completed')->count();
        // // processing order
        // $processedOrder = Order::where('user_id', $user->id)->where('order_status', 'processing')->count();
        // // pending orders
        // $pendingOrder = Order::where('user_id', $user->id)->where('order_status', 'pending')->count();
        // // failed orders
        // $failedOrder = Order::where('user_id', $user->id)->where('order_status', 'failed')->count();
        return view("dash.index", [
            'user'=>$user,
            'wishlists'=>$wishlist,
            'shippingAddress'=>$shippingAddress,
            'deliveryArea' => $deliveryArea,
        ]);
    }

    public function EditProfile(Request $request, $id){
        try {
            $user  = User::findOrFail($id);
            $user->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'address'=>$request->address,
            ]);
            return redirect()->back()->with('success', 'Profile updated successfully');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function updateProfilePicture(Request $request){
        $user = Auth::user();
        try {
            if( $request->hasFile('profile_picture')){
                $file = $request->file('profile_picture');
                $file_name = $file->getClientOriginalName();
                $file->move(public_path('images/profile'), $file_name);
                $user->update([
                    'profile_picture'=>$file_name,
                ]);
                // return redirect()->back()->with('success', 'Profile picture updated successfully');
                return response()->json(['success' => true, 'message' => 'Profile picture updated successfully']);
            }

        }catch( \Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function ChangePassword(Request $request){
        $user  = Auth::user();
        try {
            $request->validate([
                'current_password'=>'required',
                'new_password'=>'required|min:8',
                'confirm_password'=>'required|same:new_password',
            ]);
            if(Hash::check($request->current_password, $user->password)){
                $user->update([
                    'password'=>Hash::make($request->new_password),
                ]);
                return redirect()->back()->with('success', 'Password updated successfully');
            }else{
                return redirect()->back()->with('error', 'Old password does not match');
            }
        }catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}

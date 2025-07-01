<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ReviewRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReviewRatingController extends Controller
{
    public function reviewstore(Request $request){
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            // 'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);

        if(Auth::guest()){
            return back()->with('error', 'You must be logged in to submit a review.');
        }

        try{
            $review = new ReviewRating();
            $review->product_id = $validated['product_id'];
            $review->review = $validated['review'];
            // $review->rating = $validated['rating'];
            $review->user_id = Auth::user()->id;
            $review->save();
            return back()->with('success','Your review has been submitted Successfully!');
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went wrong. Please try again later.');
        }
    }
}

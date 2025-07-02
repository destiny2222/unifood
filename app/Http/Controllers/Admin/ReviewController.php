<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReviewRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
   public function index(){
       $reviews = ReviewRating::orderBy('id', 'desc')->paginate(50);
       return view('admin.review.index', [
           'reviews' => $reviews,
       ]);
   }


   public function update(Request $request, $id){
       try {
            $review = ReviewRating::find($id);
            $review->status = $request->status;
            $review->save();
            return redirect()->back()->with('success', 'Review updated successfully');
       } catch (\Exception $exception) {
           Log::error($exception->getMessage());
           return redirect()->back()->with('error', 'Something went wrong');
       }
   }

   public function destroy($id){
       try {
            $review = ReviewRating::find($id);
            $review->delete();
            return redirect()->back()->with('success', 'Review deleted successfully');
       } catch (\Exception $exception) {
           Log::error($exception->getMessage());
           return redirect()->back()->with('error', $exception->getMessage());
       }
   }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class B2BProductController extends Controller
{
   public function allProduvt(Request $request){
        $products = Product::where('is_b2b', true)->get();
        return response()->json([
            'success' => true,
            'message' => 'All products fetched successfully.',
            'data' => ProductResource::collection($products),
        ], 200);
   }
}

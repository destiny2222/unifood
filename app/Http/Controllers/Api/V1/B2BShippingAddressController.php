<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\B2BShippingAddress;
use Illuminate\Support\Facades\Validator;

class B2BShippingAddressController extends Controller
{
    /**
     * List all shipping addresses for the authenticated B2B user
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json(['message' => 'Approved Business Account required.'], 403);
        }

        $addresses = B2BShippingAddress::where('user_id', $user->id)
            ->orderByDesc('is_default')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $addresses,
        ]);
    }

    /**
     * Store a new shipping address
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json(['message' => 'Approved Business Account required.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'label'                 => 'nullable|string|max:100',
            'company_name'          => 'nullable|string|max:255',
            'contact_name'          => 'nullable|string|max:255',
            'phone'                 => 'nullable|string|max:30',
            'address_line_1'        => 'required|string|max:255',
            'address_line_2'        => 'nullable|string|max:255',
            'city'                  => 'required|string|max:255',
            'state'                 => 'nullable|string|max:255',
            'postal_code'           => 'required|string|max:20',
            'country'               => 'required|string|max:100',
            'is_default'            => 'sometimes|boolean',
            'delivery_instructions' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // If this address is set as default, unset previous defaults
        if ($request->boolean('is_default')) {
            B2BShippingAddress::where('user_id', $user->id)
                ->where('is_default', true)
                ->update(['is_default' => false]);
        }

        $address = B2BShippingAddress::create([
            'user_id'               => $user->id, 
            'label'                 => $request->label,
            'company_name'          => $request->company_name,
            'contact_name'          => $request->contact_name ?? $user->name,
            'phone'                 => $request->phone ?? $user->phone,
            'address_line_1'        => $request->address_line_1,
            'address_line_2'        => $request->address_line_2,
            'city'                  => $request->city,
            'state'                 => $request->state,
            'postal_code'           => $request->postal_code,
            'country'               => $request->country,
            'is_default'            => $request->boolean('is_default', false),
            'delivery_instructions' => $request->delivery_instructions,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Shipping address created successfully.',
            'data'    => $address,
        ], 201);
    }

    /**
     * Show a single shipping address
     */
    public function show(Request $request, string $id)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json(['message' => 'Approved Business Account required.'], 403);
        }

        $address = B2BShippingAddress::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data'    => $address,
        ]);
    }

    /**
     * Update an existing shipping address
     */
    public function update(Request $request, string $id)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json(['message' => 'Approved Business Account required.'], 403);
        }

        $address = B2BShippingAddress::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'label'                 => 'nullable|string|max:100',
            'company_name'          => 'nullable|string|max:255',
            'contact_name'          => 'nullable|string|max:255',
            'phone'                 => 'nullable|string|max:30',
            'address_line_1'        => 'sometimes|required|string|max:255',
            'address_line_2'        => 'nullable|string|max:255',
            'city'                  => 'sometimes|required|string|max:255',
            'state'                 => 'nullable|string|max:255',
            'postal_code'           => 'sometimes|required|string|max:20',
            'country'               => 'sometimes|required|string|max:100',
            'is_default'            => 'sometimes|boolean',
            'delivery_instructions' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Handle default address logic
        if ($request->has('is_default') && $request->boolean('is_default')) {
            B2BShippingAddress::where('user_id', $user->id)
                ->where('id', '!=', $address->id)
                ->where('is_default', true)
                ->update(['is_default' => false]);
        }

        $address->update($request->only([
            'label',
            'company_name',
            'contact_name',
            'phone',
            'address_line_1',
            'address_line_2',
            'city',
            'state',
            'postal_code',
            'country',
            'is_default',
            'delivery_instructions',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Shipping address updated successfully.',
            'data'    => $address->fresh(),
        ]);
    }

    /**
     * Delete a shipping address
     */
    public function destroy(Request $request, string $id)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json(['message' => 'Approved Business Account required.'], 403);
        }

        $address = B2BShippingAddress::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        // Optional: prevent deleting the last address or the default one
        // if ($address->is_default) {
        //     return response()->json([
        //         'message' => 'You cannot delete the default shipping address. Set another address as default first.'
        //     ], 400);
        // }

        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Shipping address deleted successfully.',
        ]);
    }

    /**
     * Set an address as the default
     */
    public function setDefault(Request $request, string $id)
    {
        $user = $request->user();

        if (!$user->isB2B()) {
            return response()->json(['message' => 'Approved Business Account required.'], 403);
        }

        $address = B2BShippingAddress::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        // Unset previous default
        B2BShippingAddress::where('user_id', $user->id)
            ->where('is_default', true)
            ->update(['is_default' => false]);

        $address->update(['is_default' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Default shipping address updated.',
            'data'    => $address->fresh(),
        ]);
    }
}

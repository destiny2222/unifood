<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'profile_picture' => $this->profile_picture ? asset($this->profile_picture) : null,
            'current_view' => $this->current_view,
            'address' => $this->address,
            'is_business_owner' => $this->is_business_owner,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

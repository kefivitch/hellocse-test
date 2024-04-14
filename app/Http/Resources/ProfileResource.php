<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'id' => $this->id,
            'name' => $this->name,
            'first_name' => $this->first_name,
            'image' => $this->image,
        ];

        if (auth('sanctum')->user()) {
            $response['status'] = $this->status;
        }

        return $response;
    }
}

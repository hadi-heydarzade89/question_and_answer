<?php

namespace App\Http\Resources\API\V1\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {

        return [
            'id' => $this->id,
            'full_name' => $this?->name . ' ' . $this?->last_name,
            'email' => $this->email,
            'user_suffix' => $this->user_slug,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}

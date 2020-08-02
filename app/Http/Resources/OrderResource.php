<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'food_id' => $this->food_id,
            'uuid' => $this->uuid,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'user' => new UserResource($this->user),
            'food' => new FoodResource($this->food),
        ];
    }
}

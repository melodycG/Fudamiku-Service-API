<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FoodResource extends JsonResource
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
            'name' => $this->name,
            'score' => $this->score,
            'description' => $this->description,
            'price' => $this->price,
            'picture' => url('/') . $this->picture,
            'created_at' => $this->created_at,
            'ingredients' => FoodIngredientResource::collection($this->foodIngredient)
        ];
    }
}

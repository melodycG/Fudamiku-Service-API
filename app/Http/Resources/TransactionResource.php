<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'order_id' => $this->order_id,
            'user_id' => $this->user_id,
            'uuid' => $this->uuid,
            'delivery_service' => $this->delivery_service,
            'tax' => $this->tax,
            'total_price' => $this->total_price,
            'updated_at' => $this->updated_at,
            'order' => new OrderResource($this->order)
        ];
    }
}

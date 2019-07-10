<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class AuctionProductResource extends JsonResource
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
            'start_date' => Carbon::parse($this->start_date)->format('Y-m-d'),
            'end_date' => Carbon::parse($this->end_date)->format('Y-m-d'),
            'offer' => $this->offer,
            'description' => $this->description,
            'city' => new ProvinceResource($this->whenLoaded('city')),
            'product_type' => new ProvinceResource($this->whenLoaded('productType')),
            'can_update' => $this->can_update,
            'can_delete' => $this->can_delete
        ];
    }
}

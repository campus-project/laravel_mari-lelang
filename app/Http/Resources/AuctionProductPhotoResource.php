<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class AuctionProductPhotoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $path = public_path($this->photo_url);
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'auction_product' => new AuctionProductResource($this->whenLoaded('auctionProduct')),
            'photo_url' => config('app.url', 'localhost') . '/' . $this->photo_url,
            'size' => File::size($path),
            'base64' => $base64
        ];
    }
}

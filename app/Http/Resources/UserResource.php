<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $base64 = null;
        $type = null;
        $path = null;
        if ($this->photo_url) {
            $path = public_path('/images/users/' . $this->photo_url);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'photo_url' => config('app.url', 'localhost') . '/' . $this->photo_url,
            'phone' => $this->phone,
            'address' => $this->address,
            'wallet_balance' => $this->wallet_balance,
            'account_number' => $this->account_number,
            'city' => new CityResource($this->whenLoaded('city')),
            'photo' => [
                'name' => $this->photo_url,
                'type' => $type,
                'base64' => $base64,
                'size' => File::size($path)
            ]
        ];
    }
}

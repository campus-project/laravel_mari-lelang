<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuctionProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'start_date' => 'required|date_format:Y-m-d|after:' . date('Y-m-d'),
            'end_date' => 'required|date_format:Y-m-d|after:' . $this->request->get('start_date'),
            'offer' => 'required|min:0|not_in:0',
            'product_type_id' => 'required|exists:product_types,id',
            'city_id' => 'required|exists:cities,id',
            'auction_product_photos' => 'required|array',
            'auction_product_photos.*' => 'required',
            'description' => 'nullable'
        ];
    }
}

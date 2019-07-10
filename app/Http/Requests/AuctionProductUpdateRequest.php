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
        return false;
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
            'start_date' => 'required|date_format:Y-m-d|before:tomorrow',
            'end_date' => 'required|date_format:Y-m-d|before:' . $this->request->get('start_date'),
            'offer' => 'required|min:0|not_in:0',
            'product_type_id' => 'required|exists:product_types,id',
            'city_id' => 'required|exists:cities,id',
            'description' => 'nullable'
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Rules\ValidAmountAndBid;
use App\Rules\ValidAuctionProductActive;
use Illuminate\Foundation\Http\FormRequest;

class BidCreateRequest extends FormRequest
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
            'auction_product_id' => ['required','exists:auction_products,id', new ValidAuctionProductActive()],
            'amount' => ['required','numeric', new ValidAmountAndBid($this->request->get('auction_product_id'))]
        ];
    }
}

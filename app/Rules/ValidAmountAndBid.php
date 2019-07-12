<?php

namespace App\Rules;

use App\Entities\AuctionProduct;
use App\Entities\Bid;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ValidAmountAndBid implements Rule
{
    protected $auctionProduct;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($auctionProduct)
    {
        $this->auctionProduct = $auctionProduct;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (Auth::user()->wallet_balance < $value + 5000) {
            return false;
        }

        $bid = Bid::where('auction_product_id', $this->auctionProduct)->orderBy('created_at', 'desc')->first();

        if (empty($bid)){
            $auctionProduct = AuctionProduct::find($this->auctionProduct);
            return $auctionProduct->offer <= $value;
        } else {
            return $bid->amount <= $value;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your balance is not enought, or amount must be higher than last bid amount or product offer.';
    }
}

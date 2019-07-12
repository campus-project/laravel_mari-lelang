<?php

namespace App\Rules;

use App\Entities\AuctionProduct;
use Illuminate\Contracts\Validation\Rule;

class ValidAuctionProductActive implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $auctionProduct = AuctionProduct::find($value);

        return $auctionProduct->end_date >= now();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Product expired.';
    }
}

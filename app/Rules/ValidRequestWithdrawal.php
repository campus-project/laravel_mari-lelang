<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidRequestWithdrawal implements Rule
{
    private $accountNo;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($accountNo)
    {
        $this->accountNo = $accountNo;
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
        return !empty($this->accountNo);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Before use withdrawal you must setting account number in your account.';
    }
}

<?php

namespace App\Http\Requests;

use App\Rules\ValidRequestWithdrawal;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class WithdrawalCreateRequest extends FormRequest
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
            'amount' => ['required', 'integer', 'min:10000', 'max:' . Auth::user()->wallet_balance, new ValidRequestWithdrawal(Auth::user()->account_number)]
        ];
    }
}

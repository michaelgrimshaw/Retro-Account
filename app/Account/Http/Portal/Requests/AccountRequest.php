<?php

namespace App\Account\Http\Portal\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AccountRequest
 *
 * @package App\Account\Http\Portal\Requests
 */
class AccountRequest extends FormRequest
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
            'name' => ['Required', 'string'],
            'goal' => ['Required'],
            'balance' => ['Required'],
        ];
    }
}

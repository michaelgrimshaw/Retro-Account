<?php

namespace App\Transaction\Http\Portal\Requests;

use App\Transaction\Rules\Overdraft;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class TransactionRequest
 *
 * @package App\Transaction\Http\Portal\Requests
 */
class TransactionRequest extends FormRequest
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
            'transaction_type_id' => ['Required', 'int'],
            'transaction_date' => ['Required', 'date_format:Y-m-d'],
            'description' => ['Required', 'string', 'max:255'],
            'value' => ['Required', new Overdraft],
        ];
    }
}

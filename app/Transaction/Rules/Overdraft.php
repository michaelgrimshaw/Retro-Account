<?php

namespace App\Transaction\Rules;

use App\Transaction\Models\TransactionType;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;

class Overdraft implements Rule, DataAwareRule
{

    protected $data = [];
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $account = request()->route('account');

        switch ($this->data['transaction_type_id']) {
            case TransactionType::DEPOSIT:
                $balance = $account->raw_available_balance + ($value * 100);
                break;
            case TransactionType::WITHDRAWAL:
                $balance = $account->raw_available_balance - ($value * 100);
                break;
        }

        return $balance > -$account->getRawOriginal('overdraft');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute exceeds your arranged overdraft.';
    }

    /**
     * Set the data under validation.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}

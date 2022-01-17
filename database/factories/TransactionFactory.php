<?php

namespace Database\Factories;

use App\Account\Models\Account;
use App\Transaction\Models\Transaction;
use App\Transaction\Models\TransactionType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class TransactionFactory
 *
 * @package Database\Factories
 */
class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string|null
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $account         = Account::factory();
        $transactionDate = $this->faker->dateTimeBetween('-1 years', '+1 month');

        return [
            'account_id'          => $account,
            'transaction_type_id' => TransactionType::DEPOSIT,
            'description'         => $this->faker->sentence,
            'value'               => $this->faker->randomFloat(0, 1000),
            'balance'             => null,
            'transaction_date'    => date_format($transactionDate, 'Y-m-d'),
            'processed_at'        => $transactionDate < now() ? date_format($this->faker->dateTimeBetween($transactionDate, 'now'), 'Y-m-d') : null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function deposits()
    {
        return $this->state(function (array $attributes) {
            return [
                'transaction_type_id' => TransactionType::DEPOSIT,
            ];
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withdrawals()
    {
        return $this->state(function (array $attributes) {
            return [
                'transaction_type_id' => TransactionType::WITHDRAWAL,
            ];
        });
    }
}

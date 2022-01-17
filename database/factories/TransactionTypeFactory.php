<?php

namespace Database\Factories;

use App\Transaction\Models\TransactionType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class TransactionTypeFactory
 *
 * @package Database\Factories
 */
class TransactionTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string|null
     */
    protected $model = TransactionType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function deposit()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Deposit',
            ];
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withdrawal()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Withdrawal',
            ];
        });
    }
}

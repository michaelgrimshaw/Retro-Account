<?php

namespace Database\Factories;

use App\Account\Models\Account;
use App\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class AccountFactory
 *
 * @package Database\Factories
 */
class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string|null
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'   => User::factory(),
            'reference' => '',
            'name'      => $this->faker->word,
            'balance'   => 0,
            'overdraft' => 250,
            'goal'      => 4000,
            'opened_at' => $this->faker->dateTimeBetween('-3 years', 'now'),
            'closed_at' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function closed()
    {
        return $this->state(function (array $attributes) {
            return [
                'closed_at' => $this->faker->dateTimeBetween($attributes['opened_at'], 'now'),
            ];
        });
    }
}

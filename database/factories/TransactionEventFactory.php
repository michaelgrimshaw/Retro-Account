<?php

namespace Database\Factories;

use App\Transaction\Models\Transaction;
use App\Transaction\Models\TransactionEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class TransactionEventFactory
 *
 * @package Database\Factories
 */
class TransactionEventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string|null
     */
    protected $model = TransactionEvent::class;

    protected $events = [
        'Created',
        'Processed',
        'Errored',
        ''
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'transaction_id' => Transaction::factory(),
            'name'           => $this->faker->randomElement(['Created', 'Processed', 'Errored', 'Retried']),
            'output'         => $this->faker->sentence,
            'data'           => [$this->faker->sentence],
            'triggered_at'   => $this->faker->dateTimeBetween('-3 years', 'now'),
        ];
    }
}

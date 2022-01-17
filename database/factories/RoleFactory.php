<?php

namespace Database\Factories;

use App\Acl\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class RoleFactory
 *
 * @package Database\Factories
 */
class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string|null
     */
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'       => $this->faker->word,
            'guard_name' => 'portal',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'guard_name' => 'admin',
            ];
        });
    }
}

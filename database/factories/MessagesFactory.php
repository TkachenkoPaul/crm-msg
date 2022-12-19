<?php

namespace Database\Factories;

use App\Models\Messages;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Messages>
 */
class MessagesFactory extends Factory
{

    protected $model = Messages::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fio' => fake()->name(),
            'address' => fake()->address(),
            'house' => fake()->buildingNumber(),
            'type_id' => fake()->numberBetween(1, 3),
            'phone' => fake()->phoneNumber(),
            'admin_id' => fake()->numberBetween(1,5),
            'closed' => fake()->dateTimeThisMonth()->format('Y-m-d H:i:s'),
            'status_id' => fake()->numberBetween(0,3),
            'responsible_id' => fake()->numberBetween(1,5),
            'uid' => 11111111111111,
            'created_at' => fake()->dateTimeThisMonth()->format('Y-m-d H:i:s'),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\History>
 */
class HistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data = [];
        for ($i=0; $i < fake()->numberBetween(1, 4) ; $i++) {
            $data[] = [
                'city' => fake()->city,
                'position' => ['lat' => fake()->latitude, 'lng' => fake()->longitude],
                'humidity' => fake()->numberBetween(0, 100),
            ];
        }
        
        $date = fake()->dateTimeBetween('-1 year', 'now');
        return [
            'data' => $data,
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}

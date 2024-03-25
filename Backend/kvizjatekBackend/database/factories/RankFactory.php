<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Rank;
use Illuminate\Database\Eloquent\Factories\Factory;

class RankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::all()->pluck('id')->toArray();


        return [
            'score' => $this->faker->randomNumber(),
            'user_id' => fake()->unique()->randomElement($userIds),
        ];
    }
}

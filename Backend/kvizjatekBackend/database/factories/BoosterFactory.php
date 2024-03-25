<?php

namespace Database\Factories;

use App\Models\Booster;
use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\Player;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booster>
 */
class BoosterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Booster::class;

    public function definition(): array
    {
        return [
            // Itt csak az alapértelmezett attribútumokat adod meg, például:
            'reset_on_new_game' => $this->faker->boolean // Véletlenszerű igaz/hamis érték generálása
        ];
    }

    }


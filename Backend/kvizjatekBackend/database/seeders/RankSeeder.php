<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Rank;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    public function run(): void
    {

        Rank::factory()
            ->count(15)
            ->create();
    }
}


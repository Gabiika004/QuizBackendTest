<?php

namespace Database\Seeders;

use App\Models\Booster;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Userboost;

class UserboostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::pluck('id');
        $boosterIds = Booster::pluck('id');
    
        foreach ($userIds as $userId) {
            foreach ($boosterIds as $boosterId) {
                Userboost::create([
                    'userid' => $userId,
                    'boosterid' => $boosterId,
                    'used' => false, // Alapértelmezett állapot
                ]);
            }
        }

    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Booster;

class BoosterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $boosterNames = ['felező', 'telefonhívás', 'közönség'];

        foreach ($boosterNames as $name) {
            Booster::create([
                'boostername' => $name,
                'reset_on_new_game' => false, // Vagy true, attól függően, hogy mit szeretnél
            ]);
        }
    }
}

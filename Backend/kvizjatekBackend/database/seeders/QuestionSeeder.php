<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        $csv = Reader::createFromPath(database_path('data/questions.csv'), 'r');
        $csv->setHeaderOffset(0); // Az első sor a fejléc

        foreach ($csv as $record) {
            DB::table('questions')->insert([
                'id' => $record['id'],
                'questiontext' => $record['questiontext'],
                'topic_id' => $record['topic_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

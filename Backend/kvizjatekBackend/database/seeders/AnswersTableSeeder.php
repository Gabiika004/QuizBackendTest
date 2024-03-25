<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class AnswersTableSeeder extends Seeder
{
    public function run()
    {
        $csv = Reader::createFromPath(database_path('data/answers.csv'), 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            DB::table('answers')->insert([
                'id' => $record['id'],
                'question_id' => $record['question_id'],
                'answer_text' => $record['answer_text'],
                'is_correct' => $record['is_correct'] === 'true', // Feltételezve, hogy a CSV 'true' vagy 'false' sztringeket tartalmaz
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

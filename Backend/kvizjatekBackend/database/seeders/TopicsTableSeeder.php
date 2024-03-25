<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader; // Ha a league/csv csomagot használod

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        $csv = Reader::createFromPath(database_path('data/topics.csv'), 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            DB::table('topics')->insert([
                'id' => $record['id'],
                'topicname' => $record['topicname'],
            ]);
        }
    }
}

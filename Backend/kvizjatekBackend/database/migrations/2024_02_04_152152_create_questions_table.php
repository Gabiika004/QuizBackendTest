<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('questiontext');
            // Az 'unsignedBigInteger' típus használata a 'topic_id' oszlophoz,
            // ami kompatibilis az 'id' oszloppal a 'topics' táblában
            $table->unsignedBigInteger('topic_id');
            $table->timestamps();

            // Idegen kulcs (foreign key) hozzáadása a 'topic_id' oszlophoz
            // ami a 'topics' tábla 'id' oszlopára mutat
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            // Idegen kulcs kapcsolat eltávolítása
            $table->dropForeign(['topic_id']);
        });

        Schema::dropIfExists('questions');
    }
    
};

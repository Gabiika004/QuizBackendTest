<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id(); // Egyedi azonosító
            $table->unsignedBigInteger('question_id'); // Kapcsolódó kérdés azonosítója
            $table->text('answer_text'); // A válasz szövege
            $table->boolean('is_correct')->default(false); // Helyes válasz jelölése
            $table->timestamps(); // Létrehozási és módosítási időbélyegek

            // Külső kulcs meghatározása a kapcsolódó kérdésekhez
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};

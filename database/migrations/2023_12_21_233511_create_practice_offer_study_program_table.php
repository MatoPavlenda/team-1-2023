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
        Schema::create('practice_offer_study_program', function (Blueprint $table) {
            $table->unsignedBigInteger('practice_offer_id');
            $table->unsignedBigInteger('study_program_id');

            $table->foreign('practice_offer_id')->references('id')->on('practice_offer')->onDelete('cascade');
            $table->foreign('study_program_id')->references('id')->on('study_program')->onDelete('cascade');

            $table->primary(['practice_offer_id', 'study_program_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice_offer_study_program');
    }
};

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
        Schema::create('practice', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('practice_offer_id');
            $table->string('title');
            $table->text('description');
            $table->date('startDate');
            $table->date('endDate');
            $table->boolean('active');
            $table->boolean('finished');
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('student');
            $table->foreign('practice_offer_id')->references('id')->on('practice_offer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice');
    }
};

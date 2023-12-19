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
        Schema::create('study_program2department', function (Blueprint $table) {

            $table->unsignedBigInteger('study_program_id');
            $table->unsignedBigInteger('department_id');
            $table->timestamps();

            $table->foreign('study_program_id')->references('id')->on('study_program')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('department')->onDelete('cascade');

            $table->primary(['study_program_id', 'department_id']);



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_program2department');
    }
};

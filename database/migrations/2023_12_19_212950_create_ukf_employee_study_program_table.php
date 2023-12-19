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
        Schema::create('ukf_employee_study_program', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ukf_employee_id');
            $table->unsignedBigInteger('study_program_id');
            $table->date('s_date');
            $table->date('e_date');
            $table->boolean('active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ukf_employee_id')->references('id')->on('ukf_employee')->onDelete('cascade');
            $table->foreign('study_program_id')->references('id')->on('study_program')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ukf_employee_study_program');
    }
};

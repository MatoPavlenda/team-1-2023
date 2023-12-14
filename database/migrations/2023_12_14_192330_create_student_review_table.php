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
        Schema::create('student_review', function (Blueprint $table) {
            $table->foreignId('student_id')->constrained('student')->onDelete('cascade');
            $table->foreignId('ukf_employee_id')->constrained('ukf_employee')->onDelete('cascade');
            $table->integer('rating');
            $table->text('comment');
            $table->timestamps();
            $table->primary(['student_id', 'ukf_employee_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_review');
    }
};

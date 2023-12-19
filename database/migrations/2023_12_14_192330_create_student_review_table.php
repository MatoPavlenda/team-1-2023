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
            $table->foreignId('company_employee_id')->constrained('company_employee')->onDelete('cascade');
            $table->foreignId('practice_id')->constrained('practice')->onDelete('cascade');
            $table->integer('rating');
            $table->text('comment');
            $table->timestamps();
            $table->softDeletes();
            $table->primary(['student_id', 'company_employee_id', 'practice_id']);
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

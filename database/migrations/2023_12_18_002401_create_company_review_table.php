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
        Schema::create('company_review', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_company');
            $table->unsignedBigInteger('id_practice');
            $table->unsignedBigInteger('id_student');
            $table->text('review_comment');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_company')->references('id')->on('company');
            $table->foreign('id_practice')->references('id')->on('practice');
            $table->foreign('id_student')->references('id')->on('student');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_review');
    }
};

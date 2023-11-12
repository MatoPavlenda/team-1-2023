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
        Schema::create('practice_offer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tutor_id')->nullable();
            $table->foreign('tutor_id')
                ->references('id')
                ->on('company_employee')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');
            $table->string('title');
            $table->longText('description');
            $table->date('start');
            $table->date('end');
            //$table->datetime('create_time');
            $table->integer('student_count');
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice_offer');
    }
};

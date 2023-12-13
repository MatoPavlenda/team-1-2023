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
        Schema::create('practise_report', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practise_id')->constrained('practise');
            $table->date('date');
            $table->integer('time');
            $table->text('description');
            $table->timestamps();
        });
    }
//php artisan make:migration create_practise_report_table
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practise_report');
    }
};

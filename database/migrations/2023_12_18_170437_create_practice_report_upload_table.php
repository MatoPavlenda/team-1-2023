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
        Schema::create('practice_report_upload', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('practice_id');
            $table->text('url');
            $table->boolean('active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('practice_id')->references('id')->on('practice');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice_report_upload');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('study_program', function (Blueprint $table) {
            $table->timestamps(); // Adds created_at and updated_at columns
            $table->softDeletes(); // Adds deleted_at column for soft deletes
            $table->string('program_code')->nullable(); // Adds program_code column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('study_program', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->dropSoftDeletes();
            $table->dropColumn('program_code');
        });
    }
};

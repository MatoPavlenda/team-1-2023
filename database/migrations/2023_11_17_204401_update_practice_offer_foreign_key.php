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
        Schema::table('practice_offer', function (Blueprint $table) {
            // Assuming you have a foreign key named 'tutor_id'
            $table->dropForeign(['tutor_id']);

            $table->foreign('tutor_id')
                ->references('id')->on('company_employee')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('practice_offer', function (Blueprint $table) {
            // Drop the foreign key constraints in the reverse order
            $table->dropForeign(['tutor_id']);

            $table->foreign('tutor_id')
                ->references('id')->on('company_employee')
                ->onDelete('RESTRICT');
        });
    }
};

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
        Schema::table('company_employee', function (Blueprint $table) {
            // Assuming you have a foreign key named 'company_id'
            $table->dropForeign(['company_id']);

            $table->foreign('company_id')
                ->references('id')->on('company')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_employee', function (Blueprint $table) {
            // Drop the foreign key constraints in the reverse order
            $table->dropForeign(['company_id']);

            $table->foreign('company_id')
                ->references('id')->on('company')
                ->onDelete('RESTRICT');
        });
    }
};

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
        Schema::table('company_review', function (Blueprint $table) {
            $table->unsignedInteger('rating')->nullable(false); // Adding the rating column
            $table->text('review_comment')->nullable()->change(); // Making review_comment nullable
        });
    }

    public function down()
    {
        Schema::table('company_review', function (Blueprint $table) {
            $table->dropColumn('rating'); // Remove the rating column on rollback
            // Restore review_comment to not nullable if necessary
        });
    }
};

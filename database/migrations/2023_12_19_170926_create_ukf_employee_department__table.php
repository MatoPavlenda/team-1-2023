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
        Schema::create('ukf_employee_department', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ukf_employee_id');
            $table->unsignedBigInteger('department_id');
            $table->date('d_sdate');
            $table->date('d_edate');
            $table->integer('s_active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ukf_employee_id')->references('id')->on('ukf_employee')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('department')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ukf_employee_department');
    }
};

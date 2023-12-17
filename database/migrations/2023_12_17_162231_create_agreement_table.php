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
        Schema::create('agreement', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('i_id_company');
            $table->unsignedBigInteger('i_id_student');
            $table->unsignedBigInteger('i_id_ukf_employee');
            $table->string('t_url', 255);
            $table->date('d_sdate');
            $table->date('d_edate');
            $table->date('d_cdate');
            $table->string('s_active', 255);
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('i_id_company')->references('id')->on('company')->onDelete('cascade');
            $table->foreign('i_id_student')->references('id')->on('student')->onDelete('cascade');
            $table->foreign('i_id_ukf_employee')->references('id')->on('ukf_employee')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreement');
    }
};

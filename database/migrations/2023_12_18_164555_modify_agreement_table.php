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
Schema::table('agreement', function (Blueprint $table) {
// Rename the columns in the 'agreement' table
$table->renameColumn('i_id_company', 'company_id');
$table->renameColumn('i_id_student', 'student_id');
$table->renameColumn('i_id_ukf_employee', 'ukf_employee_id');
    $table->renameColumn('t_url', 't_url-');
});
}

/**
* Reverse the migrations.
*/
public function down(): void
{
Schema::table('agreement', function (Blueprint $table) {
// Reverse the column renames in the 'agreement' table
$table->renameColumn('company_id', 'i_id_company');
$table->renameColumn('student_id', 'i_id_student');
$table->renameColumn('ukf_employee_id', 'i_id_ukf_employee');
    $table->renameColumn('t_url-', 't_url');
});
}
};

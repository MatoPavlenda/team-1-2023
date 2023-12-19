<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agreement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'student_id',
        'ukf_employee_id',
        't_url-',
        'd_sdate',
        'd_edate',
        'd_cdate',
        's_active',

    ];

    protected $table = 'agreement';

    protected $primaryKey = 'id'; // Assuming 'id' is the primary key

    protected $keyType = 'int';

    public $timestamps = true; // Laravel will automatically manage created_at and updated_at timestamps

    protected $dateFormat = 'Y-m-d H:i:s'; // Adjust the date format if needed

    public function agreement()
    {
        return $this->belongsTo(Company::class, 'company_id');

    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

        public function ukf_employee()
    {
        return $this->belongsTo(UKF_Employee::class, 'ukf_employee_id');
    }


}

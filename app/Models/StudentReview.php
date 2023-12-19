<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'company_employee_id',
        'practice_id',
        'rating',
        'comment',
    ];

    protected $table = 'student_review';

    public $incrementing = false;
    protected $keyType = 'integer';

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function company_employee()
    {
        return $this->belongsTo(UKF_Employee::class, 'company_employee_id');
    }

    public function ukf_employee()
    {
        return $this->belongsTo(UKF_Employee::class, 'ukf_employee_id');
    }
}

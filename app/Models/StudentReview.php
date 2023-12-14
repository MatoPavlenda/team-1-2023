<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'ukf_employee_id',
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

    public function ukfEmployee()
    {
        return $this->belongsTo(UKF_Employee::class, 'ukf_employee_id');
    }
}

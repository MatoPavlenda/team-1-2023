<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudyProgram extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'study_program';

    protected $fillable = [
        'name',
        'program_code'
    ];

    public function student()
    {
        return $this->belongsToMany(Student::class, 'student_study_program');
    }

    public function department()
    {
        return $this->belongsToMany(Department::class, 'study_program2department');
    }
}

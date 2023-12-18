<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = 'student';
    protected $fillable = [
        'name',
        'surname',
        'email',
        'study_program_id',
    ];

    public function studyPrograms()
    {
        return $this->belongsToMany(StudyProgram::class, 'student_study_program');
    }

    public function practiceOffers()
    {
        return $this->belongsToMany(PracticeOffer::class, 'student_practice_offer', 'student_id', 'practice_offer_id');
    }
}

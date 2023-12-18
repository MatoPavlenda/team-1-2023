<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Practice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'practice';
    protected $fillable = [
        'student_id',
        'practice_offer_id',
        'title',
        'description',
        'startDate',
        'endDate',
        'active',
        'finished',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function practiceOffer()
    {
        return $this->belongsTo(PracticeOffer::class, 'practice_offer_id');
    }
}

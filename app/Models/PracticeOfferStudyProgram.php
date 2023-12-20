<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeOfferStudyProgram extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'practice_offer_id',
        'study_program_id'
    ];

    public $timestamps = true; // Laravel will automatically manage created_at and updated_at timestamps

    protected $dateFormat = 'Y-m-d H:i:s'; // Adjust the date format if needed

    /**
     * Get the practice offer that owns the PracticeOfferStudyProgram
     */
    public function practiceOffer(): BelongsTo
    {
        return $this->belongsTo(PracticeOffer::class);
    }

    /**
     * Get the study program that owns the PracticeOfferStudyProgram
     */
    public function studyProgram(): BelongsTo
    {
        return $this->belongsTo(StudyProgram::class);
    }
}

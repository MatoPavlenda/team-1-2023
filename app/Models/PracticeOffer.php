<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeOffer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tutor_id',
        'title',
        'description',
        'start',
        'end',
        'student_count',
    ];

    protected $table = 'practice_offer';

    protected $primaryKey = 'id'; // Assuming 'id' is the primary key

    protected $keyType = 'int'; // Depending on your database, it could be 'int', 'string', etc.

    public $timestamps = true; // Laravel will automatically manage created_at and updated_at timestamps

    protected $dateFormat = 'Y-m-d H:i:s'; // Adjust the date format if needed

    public function tutor()
    {
        return $this->belongsTo(CompanyEmployee::class, 'tutor_id');
    }
}

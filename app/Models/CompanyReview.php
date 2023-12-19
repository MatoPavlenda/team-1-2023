<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyReview extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'company_review';

    protected $fillable = [
        'id_company',
        'id_practice',
        'id_student',
        'rating',
        'review_comment'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'id_company');
    }

    public function practice()
    {
        return $this->belongsTo(Practice::class, 'id_practice');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'id_student');
    }
}

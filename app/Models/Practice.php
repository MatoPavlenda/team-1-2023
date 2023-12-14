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
        'company_employee_id',
        'title',
        'description',
        'startDate',
        'endDate',
        'active',
        'finished',
    ];
}

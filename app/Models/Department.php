<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = 'department';
    protected $fillable = [
        'title',
    ];

    protected $primaryKey = 'id'; // Assuming 'id' is the primary key

    protected $keyType = 'int';

    public $timestamps = true; // Laravel will automatically manage created_at and updated_at timestamps

    protected $dateFormat = 'Y-m-d H:i:s'; // Adjust the date format if needed

    protected $dates = ['deleted_at'];

    public function study_program()
    {
        return $this->belongsToMany(StudyProgram::class, 'study_program2department');

    }

}

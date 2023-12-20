<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeReport extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'practice_id',
        'date',
        'time',
        'description',
    ];

    public $table = 'practice_report';


    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $timestamps = true;

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $dates = ['deleted_at'];

    public function practice()
    {
        return $this->belongsTo(Practice::class, 'practice_id');
    }
}

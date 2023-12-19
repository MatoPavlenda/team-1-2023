<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PractiseReport extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'practise_id',
        'date',
        'time',
        'description',
    ];

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = true;
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $dates = ['deleted_at'];
}

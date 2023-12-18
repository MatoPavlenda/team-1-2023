<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeReportUpload extends Model
{
    use HasFactory;
    use SoftDeletes;

protected $table = 'practice_report_upload';

    protected $fillable = [
        'practice_id',
        'url',
        'active',
    ];


    protected $primaryKey = 'id'; // Assuming 'id' is the primary key

    protected $keyType = 'int';

    public $timestamps = true; // Laravel will automatically manage created_at and updated_at timestamps

    protected $dateFormat = 'Y-m-d H:i:s'; // Adjust the date format if needed

    public function practice()
    {
        return $this->belongsTo(Practice::class, 'practice_id');
    }
}

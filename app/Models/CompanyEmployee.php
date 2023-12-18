<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyEmployee extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'position',
        'company_id',
    ];

    protected $table = 'company_employee';

    protected $primaryKey = 'id'; // Assuming 'id' is the primary key

    protected $keyType = 'int';

    public $timestamps = true; // Laravel will automatically manage created_at and updated_at timestamps

    protected $dateFormat = 'Y-m-d H:i:s'; // Adjust the date format if needed

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}

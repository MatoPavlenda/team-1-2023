<?php
//test
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'street',
        'city',
        'postal_code',
        'ico',
    ];

    protected $table = 'company';

    protected $primaryKey = 'id'; // Assuming 'id' is the primary key

    protected $keyType = 'int'; // Depending on your database, it could be 'int', 'string', etc.

    public $timestamps = true; // Laravel will automatically manage created_at and updated_at timestamps

    protected $dateFormat = 'Y-m-d H:i:s'; // Adjust the date format if needed

    public function contracts()
    {
        return $this->hasMany(CompanySchoolContract::class, 'company_id');
    }
}

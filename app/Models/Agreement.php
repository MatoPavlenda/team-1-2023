<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agreement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'i_id_company',
        'i_id_student',
        'i_id_ukf_employee',
        't_url',
        'd_sdate',
        'd_edate',
        'd_cdate', // možno vymazať, timestamp doplní
        's_active',

    ];

    protected $table = 'agreement';

    protected $primaryKey = 'id'; // Assuming 'id' is the primary key

    protected $keyType = 'int';

    public $timestamps = true; // Laravel will automatically manage created_at and updated_at timestamps

    protected $dateFormat = 'Y-m-d H:i:s'; // Adjust the date format if needed

    public function agreement()
    {
        return $this->belongsTo(Company::class, 'i_id_company');

    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'i_id_student');
    }

        public function ukfEmployee()
    {
        return $this->belongsTo(UKF_Employee::class, 'i_id_ukf_employee');
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UKF_employee_Department extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'ukf_employee_id',
        'department_id',
        'd_sdate',
        'd_edate',
        's_active',
    ];

    protected $table = 'ukf_employee_department';

    protected $primaryKey = 'id'; // Assuming 'id' is the primary key

    protected $keyType = 'int';

    public $timestamps = true; // Laravel will automatically manage created_at and updated_at timestamps

    protected $dateFormat = 'Y-m-d H:i:s'; // Adjust the date format if needed


    public function ukf_employee()
    {
        return $this->belongsTo(UKF_Employee::class, 'ukf_employee_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

}

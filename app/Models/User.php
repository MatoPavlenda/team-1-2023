<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use SoftDeletes, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_employee_id',
        'student_id',
        'ukf_employee_id',
        'role',
    ];

    protected $primaryKey = 'id'; // Assuming 'id' is the primary key

    protected $keyType = 'int'; // Depending on your database, it could be 'int', 'string', etc.

    public $timestamps = true; // Laravel will automatically manage created_at and updated_at timestamps

    protected $dateFormat = 'Y-m-d H:i:s'; // Adjust the date format if needed

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function companyEmployee()
    {
        return $this->belongsTo(CompanyEmployee::class, 'company_employee_id');
    }

    public function ukfEmployee()
    {
        return $this->belongsTo(UKF_Employee::class, 'ukf_employee_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $primaryKey = 'id'; // Assuming 'id' is the primary key

    protected $keyType = 'int'; // Depending on your database, it could be 'int', 'string', etc.

    public $timestamps = true; // Laravel will automatically manage created_at and updated_at timestamps

    protected $dateFormat = 'Y-m-d H:i:s'; // Adjust the date format if needed

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

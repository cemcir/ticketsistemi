<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['username','email','password','phone','isActive','lastLoginDate','image','name','surname','role'];
    protected $table='admins';
    public $timestamps=true;

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->timezone('Europe/Istanbul')->format('Y-m-d H:i:s');
    }

    protected $hidden = [
        //'password',
        //'remember_token',
    ];

    protected $casts = [
        //'email_verified_at' => 'datetime',
        "username" => "string",
        "email" => "string",
        'password' => 'hashed',
        "phone" => "string",
        "isActive" => "bool"
    ];
}

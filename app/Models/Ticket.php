<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "tickets";
    protected $primaryKey = "ticketId";
    protected $fillable = ['adminId','title','description','priority','status'];
    public $timestamps = true;

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->timezone('Europe/Istanbul')->format('Y-m-d H:i:s');
    }
}

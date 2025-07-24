<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketResponse extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table='ticket_responses';
    protected $primaryKey = 'id';
    protected $timestamp = true;
    protected $fillable = ['ticketId','adminId','responseText'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->timezone('Europe/Istanbul')->format('Y-m-d H:i:s');
    }
}

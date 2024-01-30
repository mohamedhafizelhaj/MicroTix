<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'organizer_id',
        'description',
        'startTime',
        'endTime',
        'address',
        'ticketPrice',
        'discount'
    ];

    protected $casts = [
        'startTime' => 'datetime',
        'endTime' => 'datetime'
    ];
}

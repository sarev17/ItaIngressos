<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;
    protected $fillable = [
        'poster',
        'name',
        'day',
        'start',
        'value_ticket',
        'amount_ticket',
        'info',
        'user_id',
        'active'
    ];
}

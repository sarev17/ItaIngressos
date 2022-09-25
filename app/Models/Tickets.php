<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'invoice_id',
        'customer_name',
        'customer_cpf',
        'customer_email',
        'customer_contact',
        'used',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'ticket_code',
        'ticket_url',
    ];

    /**
     * Get the event associated with the Tickets
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function event(): HasOne
    {
        return $this->hasOne(Events::class, 'id', 'event_id');
    }
}

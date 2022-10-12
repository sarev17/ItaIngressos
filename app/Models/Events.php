<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Events extends Model
{
    use HasFactory;
    protected $fillable = [
        'poster',
        'name',
        'uf',
        'city',
        'location',
        'day',
        'start',
        'value_ticket',
        'amount_ticket',
        'info',
        'user_id',
        'active'
    ];

    /**
     * Get all of the comments for the Events
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Tickets::class, 'event_id', 'id');
    }
}

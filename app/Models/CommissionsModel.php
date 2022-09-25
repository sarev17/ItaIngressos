<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionsModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'service',
        'api_percent',
    ];
}

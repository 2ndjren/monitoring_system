<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class coordinators extends Model
{
    use HasFactory;
    protected $fillable = [
        'coordinator_fname',
        'coordinator_lname',
        'coordinator_phone',
    ];
}

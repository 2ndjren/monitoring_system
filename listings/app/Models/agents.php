<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agents extends Model
{
    use HasFactory;
    protected $fillable = [
        'agent_fname',
        'agent_lname',
        'agent_phone',
        'agent_email',
    ];
}

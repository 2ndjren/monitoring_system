<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agents extends Model
{
    protected $primaryKey = 'a_id';
    use HasFactory;
    protected $fillable = [
        'agent_fname',
        'agent_lname',
        'agent_phone',
        'agent_email',
    ];
}

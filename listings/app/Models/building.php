<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class building extends Model
{
    use HasFactory;
    protected $fillable = [
        'building_name',
        'city',
        'barangay',
        'street',
    ];
}

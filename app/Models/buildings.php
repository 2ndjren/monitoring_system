<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buildings extends Model
{
    protected $primaryKey = 'b_id';

    use HasFactory;

    protected $fillable = [
        'projects_id',
        'building_name',
        'city',
        'barangay',
        'street',
    ];
}

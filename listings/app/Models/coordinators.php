<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class coordinators extends Model
{
    use HasFactory;

    protected $primaryKey = 'co_id';
    protected $fillable = [
        'co_fname',
        'co_lname',
        'co_phone',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class units extends Model
{
    use HasFactory;
    protected $primaryKey = "u_id";
    protected $fillable = [
        'unit_no',
        'unit_type',
        'buildingS_b_id',
    ];
}
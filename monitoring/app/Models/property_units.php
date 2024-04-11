<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class property_units extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "property_units";
    protected $fillable = [
        "unit_id",
        "unit_no",
        "project",
        "status",
        'unit_owner_id',
    ];
}

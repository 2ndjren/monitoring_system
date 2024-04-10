<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asso_dues extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "asso_dues";
    protected $fillable = [
        "asso_id",
        "rent_id",
        "from",
        "start",
        "end",
        "total",
        "status",
    ];
}

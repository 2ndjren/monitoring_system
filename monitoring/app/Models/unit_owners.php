<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class unit_owners extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "unit_owners";
    protected $fillable = [
        "id",
        "name",
    ];
}

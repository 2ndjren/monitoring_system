<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class unit_rentals extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "unit_rentals";
    protected $fillable = [
        "rental_id",
        "u_no",
        "rental",
        "markup",
        "deposit",
        "contract_start",
        "to_expired",
        "contract_end",
        "notified",
        "status",
    ];
}

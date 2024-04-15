<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    use HasFactory;
    protected $table = "notification";
    protected $fillable = [
        "notif_id",
        "user_id",
        "content",
        "status",
    ];
}

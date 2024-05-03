<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    use HasFactory;
    protected $primaryKey = 'notif_id';
    protected $table = 'notification';
    protected $fillable = [
        'user_id',
        'target_id',
        'user_id',
        'target_model',
        'heading',
        'content',
        'notified',
        'status',
    ];
}

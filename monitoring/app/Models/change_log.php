<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class change_log extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'change_log';
    protected $fillable = [
        'log_id',
        'user_id',
        'target_id',
        'action',
        'action_date',
    ];
}

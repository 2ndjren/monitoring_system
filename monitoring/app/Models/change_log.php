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
        'username',
        'action',
        'action_date',
    ];
}

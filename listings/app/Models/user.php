<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user extends Model
{
    use HasFactory;
    protected $primaryKey = 'user_id';
    protected $table = 'user';
    protected $fillable = [
        'avatar',
        'user_fname',
        'user_lname',
        'email',
        'contact',
        'username',
        'password',
        'status',
    ];
}

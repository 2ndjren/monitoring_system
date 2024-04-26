<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clients extends Model
{
    use HasFactory;

    protected $table = 'clients';
    protected $primaryKey = 'c_id';
    
    protected $fillable = [
        'fname',
        'lname',
        'phone',
        'email',
    ];
}

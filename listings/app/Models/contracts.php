<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contracts extends Model
{
    protected $primaryKey = 'con_id';
    use HasFactory;
    protected $fillable = [
        'clients_id',
        'units_id',
        'coordinators_id',
        'agents_id',
        'projects_id',
        'buildings_b_id',
        'units_id',
        'contract_start',
        'contract_end',
        'contract_price',
        'advance',
        'deposit',
        'client_income',
        'company_income',
        'payment_day',
        'payment_interval',
        'due_date',
        'status',

    ];
}

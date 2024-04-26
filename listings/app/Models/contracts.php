<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contracts extends Model
{
    protected $primaryKey = 'con_id';
    use HasFactory;
    protected $fillable = [
        'clients_c_id',
        'projects_id',
        'buildings_b_id',
        'units_u_id',
        'coordinators_co_id',
        'agents_a_id',
        'contract_start',
        'contract_end',
        'advance',
        'deposit',
        'tenant_price',
        'client_income',
        'company_income',
        'due_date',
        'payment_day',
        'payment_interval',
        'status',
    ];
}

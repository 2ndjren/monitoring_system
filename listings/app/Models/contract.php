<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contract extends Model
{
    use HasFactory;
    protected $fillable = [
        'clients_id',
        'unit_id',
        'coordinators_id',
        'agents_id',
        'contract_start',
        'contract_end',
        'contract_price',
        'client_income',
        'company_income',
        'payment_date',
        'due_date',
        'contract_status',
        'status',

    ];
}

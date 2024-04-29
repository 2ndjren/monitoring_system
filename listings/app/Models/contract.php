<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// @param COllection $collection

class contract extends Model
{
    protected $primaryKey = 'con_id';
    use HasFactory;
    protected $table = 'contract';
    protected $fillable = [
        'client',
        'property',
        'building',
        'unit',
        'unit_type',
        'coordinator',
        'contact',
        'agent',
        'contract_start',
        'contract_end',
        'payment_term',
        'tenant_price',
        'owner_income',
        'company_income',
        'payment_date',
        'due_date',
        'status',
    ];
}

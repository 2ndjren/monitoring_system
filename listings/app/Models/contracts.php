<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class contracts extends Model
{
    protected $table = 'contracts';
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

    public function clients(): BelongsToMany {
        return $this->belongsToMany(clients::class, 'clients_c_id', 'c_id');
    }
}

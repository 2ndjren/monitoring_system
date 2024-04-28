<?php

use App\Models\agents;
use App\Models\buildings;
use App\Models\clients;
use App\Models\coordinators;
use App\Models\projects;
use App\Models\units;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function startRow(): int
    {
        return 6; // Skip the first 5 rows
    }
    public function up(): void
    {
        Schema::create('contract', function (Blueprint $table) {
            $table->id('con_id');
            $table->string('client');
            $table->string('property_details');
            $table->string('coordinator');
            $table->string('contact');
            $table->string('agent');
            $table->string('contract_start');
            $table->string('contract_end');
            $table->string('payment_term');
            $table->string('tenant_price');
            $table->string('client_income');
            $table->string('company_income')->nullable();
            $table->string('payment_date');
            $table->string('due_date');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract');
    }
};

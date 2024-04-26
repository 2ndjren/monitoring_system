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
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id('con_id');
            $table->foreignIdFor(clients::class);
            $table->foreignIdFor(coordinators::class);
            $table->foreignIdFor(agents::class);
            $table->foreignIdFor(projects::class);
            $table->foreignIdFor(buildings::class);
            $table->foreignIdFor(units::class);
            $table->string('contract_start');
            $table->string('contract_end');
            $table->string('advance');
            $table->string('deposit');
            $table->string('tenant_price');
            $table->string('client_income');
            $table->string('company_income');
            $table->string('payment_day');
            $table->string('payment_interval');
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

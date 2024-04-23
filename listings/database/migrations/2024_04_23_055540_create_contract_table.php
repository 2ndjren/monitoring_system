<?php

use App\Models\agents;
use App\Models\clients;
use App\Models\coordinators;
use App\Models\unit;
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
        Schema::create('contract', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(clients::class);
            $table->foreignIdFor(unit::class);
            $table->foreignIdFor(coordinators::class);
            $table->foreignIdFor(agents::class);
            $table->string('contract_start');
            $table->string('contract_end');
            $table->string('payment_term');
            $table->string('tenant_price');
            $table->string('client_income');
            $table->string('comapany_income');
            $table->string('payment_date');
            $table->string('due_date');
            $table->string('contract_status');
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

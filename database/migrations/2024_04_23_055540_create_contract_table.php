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
        Schema::create('contract', function (Blueprint $table) {
            $table->id('con_id');
            $table->string('location');
            $table->string('client')->nullable();
            $table->string('property_details')->nullable();
            $table->string('coordinator')->nullable();
            $table->string('contact')->nullable();
            $table->string('agent')->nullable();
            $table->date('contract_start')->nullable();
            $table->date('contract_end')->nullable();
            $table->string('payment_term')->nullable();
            $table->double('tenant_price', 10, 2)->nullable();
            $table->double('owner_income', 10, 2)->nullable();
            $table->double('company_income', 10, 2)->nullable();
            $table->string('payment_date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('status')->nullable();
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

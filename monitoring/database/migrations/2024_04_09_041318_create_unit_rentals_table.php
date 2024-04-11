<?php

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
        Schema::create('unit_rentals', function (Blueprint $table) {
            $table->string('rental_id')->primary();
            $table->string('u_no');
            $table->string('rental');
            $table->string('markup')->nullable();
            $table->string('deposit');
            $table->date('contract_start');
            $table->date('contract_end');
            $table->tinyInteger('notified');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_rentals');
    }
};
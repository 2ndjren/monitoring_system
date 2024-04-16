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
        Schema::create('asso_dues', function (Blueprint $table) {
            $table->string('asso_id')->primary();
            $table->string('rent_id');
            $table->date('start');
            $table->date('end');
            $table->string('total');
            $table->string('status');
            $table->foreign('rent_id')->references('rental_id')->on('unit_rentals')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asso_dues');
    }
};

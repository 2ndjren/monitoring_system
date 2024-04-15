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
        Schema::create('change_log', function (Blueprint $table) {
            $table->id('log_id');
            $table->integer('user_id');
            $table->string('target_id');
            $table->text('action');
            $table->dateTime('action_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_log');
    }
};

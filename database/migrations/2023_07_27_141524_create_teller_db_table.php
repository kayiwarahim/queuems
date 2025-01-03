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
        Schema::create('teller_db', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('teller_name');
            $table->string('status');
            $table->foreignId('current_customer_id');
            $table->string('operator');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teller_db');
    }
};

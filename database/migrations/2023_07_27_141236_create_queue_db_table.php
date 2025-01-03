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
        Schema::create('queue_db', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('priority_number');
            $table->enum('status', ['Waiting', 'Serving', 'Finished']);
            $table->enum('purpose', ['Transfer', 'Enrollment', 'Evaluation', 'Submission', 'Shift']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queue_db');
    }
};

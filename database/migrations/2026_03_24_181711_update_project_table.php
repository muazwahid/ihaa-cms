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
        Schema::table('projects', function (Blueprint $table) {
            // 1. Remove the old columns
            $table->dropColumn(['lat', 'lng']);
            
            // 2. Add the new columns
            $table->decimal('project_cost', 15, 2)->nullable();
            $table->date('date_started')->nullable();
            $table->date('date_ended')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // To undo this migration: 
            // 1. Remove the new columns
            $table->dropColumn(['project_cost', 'date_started', 'date_ended']);
            
            // 2. Put the old columns back
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
        });
    }
};
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
Schema::create('forms', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // Name of the form (e.g., "Contact Us")
        $table->string('slug')->unique();
        $table->json('content'); // This stores the drag-and-drop builder data
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};

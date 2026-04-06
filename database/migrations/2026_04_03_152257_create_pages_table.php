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
    Schema::create('pages', function (Blueprint $table) {
        $table->id();
        $table->json('title'); // Translatable
        $table->json('content')->nullable(); // Translatable
        $table->string('slug')->unique();
        $table->string('status')->default('draft'); // draft, published
        $table->foreignId('parent_id')->nullable()->constrained('pages')->nullOnDelete();
        $table->integer('sort_order')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};

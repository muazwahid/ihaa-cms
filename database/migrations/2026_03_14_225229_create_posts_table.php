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
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        
        // JSON columns for Multi-language (English/Dhivehi)
        $table->json('title'); 
        $table->json('content');
        
        // SEO & Routing
        $table->string('slug')->unique();
        $table->string('category')->index(); // e.g., 'news', 'notices', 'reports'
        
        // UI & Layout Controls
        $table->string('featured_image')->nullable();
        $table->boolean('is_featured')->default(false); // To show in the "Big News" spot
        $table->boolean('show_sidebar')->default(true);
        
        // Dynamic Sidebar: Stores an array of widget types or custom links
        $table->json('sidebar_config')->nullable(); 
        
        $table->enum('status', ['draft', 'published'])->default('draft');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

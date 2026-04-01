<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            
            // Content
            $table->json('title');            // Translatable (Spatie)
            $table->string('slug')->unique(); // For URLs (e.g., /events/annual-meeting)
            $table->json('description');      // Translatable (Spatie)
            $table->json('venue');            // Translatable (e.g., "Council Hall")
            
            // Timing
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->time('event_time')->nullable();
            
            // Media
            $table->string('photo')->nullable();          // Main Event Image
            $table->string('featured_photo')->nullable(); // High-res for banners
            
            // Relationships
            // Note: Ensure 'galleries' table exists before running this, 
            // or use ->nullable() without ->constrained() if you haven't built it yet.
            $table->foreignId('gallery_id')
          ->nullable()
          ->constrained('galleries') // This automatically assumes 'id' on 'galleries'
          ->onDelete('set null');
            
            // Status & Automation
            $table->boolean('is_featured')->default(false);
            $table->boolean('news_generated')->default(false); // Prevents duplicate news posts
            $table->string('status')->default('upcoming');     // upcoming, ongoing, completed, cancelled
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
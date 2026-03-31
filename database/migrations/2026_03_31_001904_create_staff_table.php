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
        Schema::create('staff', function (Blueprint $table) {
    $table->id();
    $table->json('name');           // {'en': 'Ahmed', 'dv': 'އަޙްމަދު'}
    $table->json('designation');    // {'en': 'Council President', 'dv': 'ކައުންސިލް ރައީސް'}
    $table->string('category');     // 'council', 'admin', 'technical'
    $table->string('email')->nullable();
    $table->string('contact_num')->nullable();
    $table->json('responsibility')->nullable(); // RichText translatable
    $table->string('photo')->nullable();
    $table->integer('sort_order')->default(0);  // Lower = Higher in hierarchy
    $table->boolean('is_active')->default(true);
    $table->timestamps();
    $table->foreignId('staff_category_id')->constrained()->cascadeOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};

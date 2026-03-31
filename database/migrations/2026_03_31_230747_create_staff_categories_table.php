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
        Schema::create('staff_categories', function (Blueprint $table) {
    $table->id();
    $table->json('name'); // Stores {'en': 'Management', 'dv': 'މެނޭޖްމަންޓް'}
    $table->string('slug')->unique();
    $table->integer('sort_order')->default(0);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_categories');
    }
};

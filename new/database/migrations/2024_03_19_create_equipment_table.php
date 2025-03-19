<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->text('description')->nullable();
            $table->string('status')->default('available');
            $table->string('image')->nullable();
            $table->foreignId('booked_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('event_name')->nullable();
            $table->string('location')->nullable();
            $table->timestamp('booked_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
}; 
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id(); // Primary key (Auto Increment)
            $table->string('name'); // Equipment Name
            $table->string('category'); // Category (Camera, Tripod, etc.)
            $table->text('description')->nullable(); // Optional Description
            $table->string('image')->nullable(); // Equipment Image Path
            $table->enum('status', ['available', 'booked'])->default('available'); // Equipment Status
            
            // Booking Information
            $table->unsignedBigInteger('booked_by')->nullable(); // User ID who booked
            $table->string('event_name')->nullable(); // Name of Event
            $table->string('location')->nullable(); // Event Location
            $table->timestamp('booked_at')->nullable(); // Booking Time
            
            // Foreign Key Constraint (Ensure user exists in the users table)
            $table->foreign('booked_by')->references('id')->on('users')->onDelete('set null');
            
            $table->timestamps(); // Created at & Updated at
            $table->softDeletes(); // Allows soft deletion (optional)
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipment');
    }
};
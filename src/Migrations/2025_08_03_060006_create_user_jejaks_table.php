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
        Schema::create('user_jejaks', function (Blueprint $table) {
            $table->id();
            
            // User information
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session_id', 100);
            
            // Request information
            $table->string('ip_address', 45);
            $table->text('user_agent')->nullable();
            $table->text('url');
            $table->text('full_url');
            $table->string('method', 10)->default('GET');
            $table->string('page_title')->nullable();
            $table->text('referrer')->nullable();
            
            // Device & Browser information
            $table->string('device_type', 20)->nullable(); // mobile, tablet, desktop
            $table->string('browser', 50)->nullable();
            $table->string('browser_version', 20)->nullable();
            $table->string('platform', 50)->nullable();
            $table->boolean('is_mobile')->default(false);
            $table->boolean('is_tablet')->default(false);
            $table->boolean('is_desktop')->default(false);
            $table->boolean('is_robot')->default(false);
            
            // Location information (optional, for future enhancement)
            $table->string('country', 100)->nullable();
            $table->string('city', 100)->nullable();
            
            // Time tracking
            $table->integer('duration_seconds')->nullable();
            $table->timestamp('visited_at');
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['user_id', 'visited_at']);
            $table->index(['session_id', 'visited_at']);
            $table->index('visited_at');
            $table->index('url');
            $table->index('device_type');
            $table->index('browser');
            $table->index(['ip_address', 'visited_at']);
            
            // Foreign key constraint (optional)
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_jejaks');
    }
};
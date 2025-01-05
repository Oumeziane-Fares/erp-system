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
        Schema::create('users', function (Blueprint $table) {
            // Primary key
            $table->id('user_id'); // Auto-incrementing primary key

            // User details
            $table->string('username', 50)->unique(); // Unique username
            $table->string('email', 100)->unique(); // Unique email
            $table->string('password_hash', 255); // Password hash
            $table->string('phone_number', 20)->nullable(); // Phone number (optional)
            $table->string('account_status', 20)->default('active'); // Account status (default: active)
            $table->timestamp('last_login')->nullable(); // Last login timestamp (optional)
            $table->integer('login_attempts')->default(0); // Failed login attempts (default: 0)

            // Address details
            $table->string('address', 255)->nullable(); // Address (optional)
            $table->string('city', 50)->nullable(); // City (optional)
            $table->string('country', 50)->nullable(); // Country (optional)
            $table->string('postal_code', 20)->nullable(); // Postal code (optional)

            // Profile details
            $table->string('profile_picture', 255)->nullable(); // Profile picture URL (optional)
            $table->string('employee_id', 50)->nullable()->unique(); // Employee ID (optional, unique)
            $table->string('job_title', 50)->nullable(); // Job title (optional)
            $table->text('signature')->nullable(); // Signature (optional)

            // Security settings
            $table->boolean('two_factor_auth')->default(false); // Two-factor authentication (default: false)

            // Timestamps
            $table->timestamp('created_at')->useCurrent(); // created_at with default CURRENT_TIMESTAMP
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // updated_at with default CURRENT_TIMESTAMP and ON UPDATE CURRENT_TIMESTAMP

            // Foreign key to users (who created this user)
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');

            // JWT "Remember Me" functionality
            $table->rememberToken(); // remember_token column

            // Indexes
            $table->index('email');
            $table->index('username');
            $table->index('employee_id');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

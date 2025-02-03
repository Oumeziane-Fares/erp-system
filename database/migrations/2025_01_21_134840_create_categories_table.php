<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id('category_id'); // Primary key with custom name
            $table->string('category_name', 100)->unique();
            $table->text('description')->nullable();
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('categories', 'category_id')
                ->onDelete('set null');
            $table->text('picture')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('created_by');
            
            // Foreign key to users table
            $table->foreign('created_by')
                ->references('user_id')
                ->on('users')
                ->onDelete('restrict'); // Prevents user deletion if they have created categories

            // Unique index for category_name (already handled by ->unique() above)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

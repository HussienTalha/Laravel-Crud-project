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
            $table->text('title');
            $table->text('content');
            $table->text('status');
            $table->string('image');
            $table->time('created_at');
            $table->foreignId('user_id')
                  ->onDelete('cascade')
                  ->onUpdate('cascade')
                  ->constrained('users');
            $table->foreignId('category_id')
                  ->nullOnUpdate()
                  ->cascadeOnUpdate()
                  ->nullable()
                  ->constrained('categories');
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

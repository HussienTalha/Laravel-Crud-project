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
            $table->text('post');
            $table->text('status');
          //  $table->string('image');
            $table->timestamps();
            $table->foreignId('user_id')
                  ->onDelete('cascade')
                  ->onUpdate('cascade')
                  ->constrained('users');
            $table->foreignId('category_id')
                  ->nullOnDelete()
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

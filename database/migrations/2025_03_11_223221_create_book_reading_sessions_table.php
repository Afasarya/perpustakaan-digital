<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_reading_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->integer('current_page')->default(1);
            $table->integer('last_page_read')->default(1);
            $table->timestamp('last_read_at')->nullable();
            $table->timestamps();
            
            // Pastikan satu user hanya memiliki satu sesi membaca untuk satu buku
            $table->unique(['user_id', 'book_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_reading_sessions');
    }
};

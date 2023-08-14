<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('c_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_id')->nullable()
                ->constrained('users')->onDelete('cascade');
            $table->foreignId('to_id')->nullable()
                ->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_conversations');
    }
};

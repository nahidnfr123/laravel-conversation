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
        Schema::create('c_room_messages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('c_room_id')->nullable()
                ->constrained('c_rooms')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()
                ->constrained('users')->onDelete('cascade');
            $table->text('body')->nullable();
            $table->text('attachment')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->boolean('seen')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_room_messages');
    }
};

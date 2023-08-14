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
        Schema::create('c_messages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('c_conversation_id')
                ->nullable()
                ->constrained('c_conversations')
                ->onDelete('set null');
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
        Schema::dropIfExists('c_messages');
    }
};

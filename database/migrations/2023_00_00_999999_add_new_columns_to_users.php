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
        Schema::table('users', function (Blueprint $table) {
            // if not exist, add the new column
            if (!Schema::hasColumn('users', 'active_status')) {
                $table->boolean('active_status')->default(0);
            }
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->default(config('conversation.user_avatar.default'));
            }
            if (!Schema::hasColumn('users', 'dark_mode')) {
                $table->boolean('dark_mode')->default(0);
            }
            if (!Schema::hasColumn('users', 'messenger_color')) {
                $table->string('messenger_color')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('active_status');
            $table->dropColumn('avatar');
            $table->dropColumn('dark_mode');
            $table->dropColumn('messenger_color');
        });
    }
};

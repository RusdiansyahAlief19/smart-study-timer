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
            // Streak harian berturut-turut
            $table->unsignedInteger('streak_count')->default(0)->after('remember_token');

            // Tanggal terakhir streak aktif
            $table->date('last_streak_date')->nullable()->after('streak_count');

            // Total sesi yang pernah diselesaikan (lifetime)
            $table->unsignedInteger('total_sessions')->default(0)->after('last_streak_date');

            // Streak terpanjang yang pernah dicapai
            $table->unsignedInteger('longest_streak')->default(0)->after('total_sessions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'streak_count',
                'last_streak_date',
                'total_sessions',
                'longest_streak',
            ]);
        });
    }
};
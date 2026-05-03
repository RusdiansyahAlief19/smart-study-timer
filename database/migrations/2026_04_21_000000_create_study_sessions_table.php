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
        Schema::create('study_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Mode: 'fixed' atau 'flowtime'
            $table->enum('mode', ['fixed', 'flowtime'])->default('fixed');

            // Preset untuk fixed mode: 'pomodoro' atau 'rule_52_17'
            $table->string('preset')->nullable();

            // Durasi dalam detik
            $table->unsignedInteger('study_duration')->comment('Durasi belajar dalam detik');
            $table->unsignedInteger('break_duration')->comment('Durasi istirahat dalam detik');

            // Status sesi
            $table->enum('status', ['completed', 'skipped', 'interrupted'])->default('completed');

            // Tanggal sesi (untuk tracking streak harian)
            $table->date('session_date');

            $table->timestamps();

            // Index untuk query streak
            $table->index(['user_id', 'session_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_sessions');
    }
};
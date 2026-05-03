<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, clear all chronotype data to avoid truncation issues
        DB::table('users')->update([
            'wake_up_time' => null,
            'productivity_peak' => null,
            'age' => null,
            'chronotype' => null,
            'optimal_study_hours' => null,
            'chronotype_completed' => false
        ]);
        
        // Then modify the column to support longer values
        Schema::table('users', function (Blueprint $table) {
            $table->string('productivity_peak', 50)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('productivity_peak', 20)->nullable()->change();
        });
    }
};

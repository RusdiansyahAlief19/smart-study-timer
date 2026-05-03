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
            $table->time('wake_up_time')->nullable()->after('email');
            $table->enum('productivity_peak', ['morning', 'afternoon', 'evening'])->nullable()->after('wake_up_time');
            $table->integer('age')->nullable()->after('productivity_peak');
            $table->enum('chronotype', ['early_bird', 'intermediate', 'night_owl'])->nullable()->after('age');
            $table->json('optimal_study_hours')->nullable()->after('chronotype');
            $table->boolean('chronotype_completed')->default(false)->after('optimal_study_hours');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'wake_up_time',
                'productivity_peak', 
                'age',
                'chronotype',
                'optimal_study_hours',
                'chronotype_completed'
            ]);
        });
    }
};

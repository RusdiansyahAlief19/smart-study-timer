<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('study_sessions', function (Blueprint $table) {
            $table->string('session_note', 180)->nullable()->after('focus_note');
        });
    }

    public function down(): void
    {
        Schema::table('study_sessions', function (Blueprint $table) {
            $table->dropColumn('session_note');
        });
    }
};

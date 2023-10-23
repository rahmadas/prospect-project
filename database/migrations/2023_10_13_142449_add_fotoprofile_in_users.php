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
            $table->string('foto_profile')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // if (Schema::hasColumn('events', 'foto_profile')) {
            //     $table->dropColumn('foto_profile')->nullable()->change();
            // } else {
            //     // Jika kolom 'foto_profile' tidak ada, Anda bisa menambahkannya dengan nullable
            //     $table->dropColumn('foto_profile')->nullable();
            // }
        });
    }
};
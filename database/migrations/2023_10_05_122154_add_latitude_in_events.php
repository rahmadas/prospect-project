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
        Schema::table('events', function (Blueprint $table) {
            // $table->string('latitude')->after('end_date');
            // $table->string('longitude')->after('latitude');
            // $table->string('location')->nullable()->after('latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // $table->dropColumn('latitude');
            // $table->dropColumn('longitude');
            // $table->dropColumn('location')->nullable()->after('longitude');
            //Periksa apakah kolom 'location' memiliki atribut nullable
            // if (Schema::hasColumn('events', 'location')) {
            //     $table->dropColumn('location')->nullable()->change();
            // } else {
            //     // Jika kolom 'location' tidak ada, Anda bisa menambahkannya dengan nullable
            //     $table->dropColumn('location')->nullable();
            // }
        });
    }
};
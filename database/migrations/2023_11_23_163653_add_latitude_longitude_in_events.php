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
            // $table->date('start_date')->change();
            // $table->date('end_date')->change();
            // $table->string('latitude')->after('end_date');
            // $table->string('longitude')->after('latitude');
            $table->time('reminder')->after('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // $table->dropColumn('reminder');
        });
    }
};

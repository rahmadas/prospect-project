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
        Schema::table('tasks', function (Blueprint $table) {
            // $table->dropColumn('due_date');
            // $table->dropColumn('due_time');
            // $table->date('start_date')->after('note');
            // $table->date('end_date')->after('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // $table->date('due_date');
            // $table->time('due_time');
            // $table->dropColumn('start_date');
            // $table->dropColumn('end_date');
        });
    }
};

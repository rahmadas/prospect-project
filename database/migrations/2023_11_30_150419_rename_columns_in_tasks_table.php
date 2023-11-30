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
            $table->renameColumn('due_date', 'start_date');
            $table->renameColumn('due_time', 'end_date');
            $table->time('start_date')->change();
            $table->time('end_date')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Reverse changes if needed
            $table->renameColumn('start_date', 'due_date');
            $table->renameColumn('end_date', 'due_time');
            $table->time('start_date')->change();
            $table->time('end_date')->change();
        });
    }
};
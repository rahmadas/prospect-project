<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // $table->unsignedBigInteger('contact_id')->after('status')->nullable();
            // $table->foreign('contact_id')
            //     ->references('id')->on('contacts')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // $table->dropColumn(['contact_id']);
            // $table->dropForeign(['contact_id']);
            // Continue with other modifications or fixes

            // ...

            // Add the foreign key constraint again
            // $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
        });
    }
};
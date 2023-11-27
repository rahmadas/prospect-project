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
        Schema::table('contact_categories', function (Blueprint $table) {
            $table->dropForeign(['contact_id']);
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade');
            //
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_categories', function (Blueprint $table) {
            //
        });
    }
};

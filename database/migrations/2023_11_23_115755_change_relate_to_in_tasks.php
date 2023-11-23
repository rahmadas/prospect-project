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
            //     $table->bigInteger('relate_to')->unsigned()->after('status');
            //     $table->foreign('relate_to')
            //         ->references('id')->on('contacts')
            //         ->onDelete('cascade');
            //     $table->dateTime('start_date')->after('note');
            //     $table->dateTime('end_date')->after('start_date');
            //     $table->enum('priority', ['low', 'medium', 'hight'])
            //         ->after('end_date');
            //     $table->time('reminder')->after('priority');

            // $table->date('start_date')->change();
            // $table->date('end_date')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // $table->dropForeign(['relate_to']);
            // $table->dropColumn('relate_to');
            // $table->dropColumn('priority');
            // $table->dropColumn('reminder');
            // $table->dropColumn('start_date');
            // $table->dropColumn('end_date');
        });
    }
};

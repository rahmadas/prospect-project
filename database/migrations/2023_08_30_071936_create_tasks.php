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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('title');
            $table->string('note');
            $table->date('due_date');
            $table->dateTime('due_time');
            $table->enum('priority', ['low', 'medium', 'hight']);
            $table->dateTime('reminder');
            $table->enum('status', ['completed', 'not_completed', 'due_today']);
            $table->bigInteger('relate_to');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};

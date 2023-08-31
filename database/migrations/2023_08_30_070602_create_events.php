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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')
            ->foreignId()
            ->constrained();
            $table->string('title');
            $table->string('meeting_with');
            $table->enum('meeting_type', ['create_event', 'create_presentation', 'create_followup_event', 'create_call_event']);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('location');
            $table->dateTime('reminder');
            $table->string('note');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

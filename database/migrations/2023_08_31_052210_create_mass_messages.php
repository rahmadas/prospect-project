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
        Schema::create('mass_messages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')
            ->foreignId()
            ->constrained();
            $table->bigInteger('message_template_id')
            ->foreignId()
            ->constrained();
            $table->varchar('message');
            $table->enum('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mass_messages');
    }
};

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
        Schema::create('contact_mass', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('contact_id')
            ->foreignId()
            ->constrained();
            $table->bigInteger('mass_message_id')
            ->foreignId()
            ->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_mass');
    }
};

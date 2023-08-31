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
        Schema::create('user_pro_features', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')
            ->foreignId()
            ->constrained();
            $table->bigInteger('pro_feature_id')
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
        Schema::dropIfExists('user_pro_features');
    }
};

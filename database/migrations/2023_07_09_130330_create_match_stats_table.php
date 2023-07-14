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
        Schema::create('match_stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('football_match_id');
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('param_id');
            $table->string('param_name');
            $table->string('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_stats');
    }
};

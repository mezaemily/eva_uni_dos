<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mine_tiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('mine_games')->cascadeOnDelete();
            $table->integer('position');
            $table->boolean('is_mine');
            $table->boolean('revealed')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mine_tiles');
    }
};
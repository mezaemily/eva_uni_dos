<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sport_id')->constrained()->cascadeOnDelete();
            $table->foreignId('team_home_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignId('team_away_id')->constrained('teams')->cascadeOnDelete();
            $table->dateTime('match_date');
            $table->integer('home_score')->nullable();
            $table->integer('away_score')->nullable();
            $table->string('status')->default('scheduled');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
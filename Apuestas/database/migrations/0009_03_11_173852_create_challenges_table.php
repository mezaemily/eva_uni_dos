<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('users');
            $table->foreignId('opponent_id')->constrained('users');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('challenges');
    }
};
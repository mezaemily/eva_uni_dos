<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('odds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bet_type_id')->constrained()->cascadeOnDelete();
            $table->string('option_name');
            $table->decimal('odd_value',10,2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('odds');
    }
};
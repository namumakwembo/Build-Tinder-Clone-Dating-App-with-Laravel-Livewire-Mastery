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
        Schema::create('swipe_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('swipe_id_1')->constrained('swipes')->cascadeOnDelete();
            $table->foreignId('swipe_id_2')->constrained('swipes')->cascadeOnDelete();

            #unique 
            $table->unique(['swipe_id_1','swipe_id_2']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('swipe_matches');
    }
};

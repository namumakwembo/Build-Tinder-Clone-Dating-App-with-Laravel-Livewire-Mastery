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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();

            //new data
            $table->string('about')->nullable();
            $table->timestamp('boosted_until')->nullable();
            $table->string('profession')->nullable();
            $table->string('university')->nullable();
            $table->string('city')->nullable();
            $table->unsignedFloat('height')->nullable();
            $table->unsignedBigInteger('age')->nullable();

           // $table->enum('relationship_goals',['new friends','another'])->nullable();
            $table->string('relationship_goals')->nullable();//create enum class

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

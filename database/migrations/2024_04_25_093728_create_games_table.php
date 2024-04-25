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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->integer('nom')->unique();
            $table->unsignedBigInteger('userid')->nullable();
            $table->unsignedBigInteger('scoreid')->nullable();
            $table->unsignedBigInteger('gameid')->nullable();
            $table->boolean('type');
            $table->string('password')->nullable();
            $table->timestamps();

            // Set foreign key constraints
            $table->foreign('userid')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            $table->foreign('scoreid')
                  ->references('id')
                  ->on('scores')
                  ->onDelete('set null');

            $table->foreign('gameid')
                  ->references('id')
                  ->on('games')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};

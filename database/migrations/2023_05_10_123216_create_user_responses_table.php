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
        Schema::create('user_responses', function (Blueprint $table) {
            $table->id();            
            $table->integer('registered_user_id')->unsigned();
            $table->date('response_date');
            $table->integer('area_id')->nullable();
            $table->integer('market_id')->nullable();
            $table->string('location',50)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('registered_user_id')->references('id')->on('registered_users')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
            $table->foreign('market_id')->references('id')->on('markets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_responses');
    }
};

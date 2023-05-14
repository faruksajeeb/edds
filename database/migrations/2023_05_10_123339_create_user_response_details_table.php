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
        Schema::create('user_response_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('response_id')->unsigned();
            $table->bigInteger('question_id')->unsigned();
            $table->bigInteger('sub_question_id')->unsigned();
            $table->string('response');
            
            $table->foreign('response_id')->references('id')->on('user_responses')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('sub_question_id')->references('id')->on('sub_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_response_details');
    }
};

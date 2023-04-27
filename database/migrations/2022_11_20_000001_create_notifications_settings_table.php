<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('employee', ['yes', 'no'])->default('no');
            $table->enum('holidays', ['yes', 'no'])->default('no');
            $table->enum('leaves', ['yes', 'no'])->default('no');
            $table->enum('events', ['yes', 'no'])->default('no');
            $table->enum('chat', ['yes', 'no'])->default('no');
            $table->enum('jobs', ['yes', 'no'])->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications_settings');
    }
};

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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false);
            $table->date('date')->nullable(false);
            $table->time('time')->nullable(false);
            $table->string('locationType')->nullable(false);
            $table->string('location')->nullable();
            $table->boolean('expired')->default(0);
            $table->string('status')->default('pending');
            $table->boolean('important')->default(0);
            $table->boolean('notify')->default(1);
            $table->string('description')->nullable();
            $table->bigInteger('user_id')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};

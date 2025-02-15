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
        //
        Schema::create('submission_logs', function (Blueprint $table)
        {
            $table->bigIncrements('log_id');
            $table->unsignedBigInteger('input_id')->nullable();
            $table->timestamps();

            $table->foreign('input_id')->references('input_id')->on('user_input')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('submission_logs');
    }
};

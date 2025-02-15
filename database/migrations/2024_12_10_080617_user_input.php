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
        Schema::create('user_input', function (Blueprint $table)
        {
            $table->bigIncrements('input_id');
            $table->string('textBox');
            $table->string('checkBox');
            $table->string('radioBox');
            $table->string('imageLocation');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('user_input');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TemporaryTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporary_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('otp');
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('reciver_id');
            $table->bigInteger('amount');
            $table->string('message')->nullable();
            $table->timestamps();

            $table->index('sender_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temporary_transactions');
    }
}

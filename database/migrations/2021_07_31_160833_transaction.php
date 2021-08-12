<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('reciver_id');
            $table->unsignedBigInteger('sender_account_id');
            $table->unsignedBigInteger('reciver_account_id');
            $table->bigInteger('amount');
            $table->bigInteger('sender_balance');
            $table->bigInteger('reciver_balance');
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
        Schema::dropIfExists('transactions');
    }
}

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
        Schema::create('transactions', function (Blueprint $table) {
          $table->id();
          $table->integer('created_by')->nullable();
          $table->integer('sender_id')->nullable();
          $table->integer('receiver_id')->nullable();
          $table->double('amount', 8, 2)->default(0);
          $table->double('balance', 8, 2)->default(0);
          $table->string('type')->nullable();
          $table->text('description')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};

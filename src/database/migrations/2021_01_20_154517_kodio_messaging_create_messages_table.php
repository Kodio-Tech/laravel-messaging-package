<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KodioMessagingCreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kodio_messaging_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sended_by_id');
            $table->unsignedBigInteger('target_user_id');
            $table->boolean('readed')->default(0);
            $table->string('title');
            $table->text('message');
            $table->timestamps();

            $table->foreign('sended_by_id')->references('id')->on('users');
            $table->foreign('target_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kodio_messaging_messages');
    }
}

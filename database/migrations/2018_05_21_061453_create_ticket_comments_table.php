<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ticket_id');   
            $table->unsignedInteger('user_id');   
            $table->string('author_name',255);
            $table->text('content');
            $table->boolean('leksys');
            $table->timestamps();
            
            $table->foreign('ticket_id')
            ->references('id')->on('tickets')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_comments');
    }
}

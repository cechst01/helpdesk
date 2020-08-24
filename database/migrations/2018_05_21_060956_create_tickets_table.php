<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100);
            $table->string('project',100);
            $table->text('content');
            $table->text('private_note')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('type_id');            
            $table->unsignedInteger('state_id');            
            $table->date('date_of_completion_client');
            $table->date('date_of_completion_leksys')->nullable();
            $table->date('send_to_approve')->nullable();
            $table->integer('credits_offer')->nullable();
            $table->integer('credits_real')->nullable();            
            $table->boolean('invoiced')->default(0);
            $table->timestamps();
            
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            
            $table->foreign('type_id')
            ->references('id')->on('ticket_types')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            
            $table->foreign('state_id')
            ->references('id')->on('ticket_states')
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
        Schema::dropIfExists('tickets');
    }
}

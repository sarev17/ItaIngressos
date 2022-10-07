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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->text('poster');
            $table->text('uf');
            $table->text('city');
            $table->text('location');
            $table->text('name');
            $table->date('day');
            $table->text('start');
            $table->float('value_ticket');
            $table->integer('amount_ticket');
            $table->text('info')->nullable();
            $table->boolean('active')->default(1);
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
        Schema::table('events',function(Blueprint $table){
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('events');
    }
};

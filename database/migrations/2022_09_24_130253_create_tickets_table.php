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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->text('invoice_id');
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->text('customer_name');
            $table->text('customer_cpf');
            $table->text('customer_email');
            $table->text('customer_contact');
            $table->boolean('used')->default(1);
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
        Schema::table('tickets',function(Blueprint $table){
            $table->dropForeign(['event_id']);
        });
        Schema::dropIfExists('tickets');
    }
};

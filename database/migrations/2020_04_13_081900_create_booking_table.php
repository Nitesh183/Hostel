<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->increments('id')->index();

            $table->unsignedInteger('hostel_id')->index();
            $table->string('owner_id', 50);
            $table->string('room_id', 50);
            $table->string('requestor_name', 300);
            $table->string('requestor_address', 300);
            $table->string('requestor_phone', 300);
            $table->string('confirmed', 5);
            $table->timestamps();
        
            
            $table->foreign('hostel_id')
            ->references('hostel_id')
            ->on('hostel_room')
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
        Schema::dropIfExists('booking');
    }
}

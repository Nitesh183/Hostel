<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hostel', function (Blueprint $table) {
            $table->increments('hostel_id')->index();
            $table->unsignedBigInteger('owner_id')->index();
            $table->string('hostel_name', 50);
            $table->string('description', 1000);
            $table->string('address', 100);
            $table->string('phone_number', 50);
            $table->string('contact_person', 50);
            $table->string('accomodation_for', 50);
            $table->timestamps();

            $table->foreign('owner_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('hostel');
    }
}

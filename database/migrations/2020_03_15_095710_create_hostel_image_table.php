<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostelimageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hostel_image', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->unsignedInteger('hostel_id')->index();
            $table->string('filename', 300);
            $table->timestamps();

            $table->foreign('hostel_id')
                ->references('hostel_id')
                ->on('hostel')
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
        Schema::dropIfExists('hostelimage');
    }
}

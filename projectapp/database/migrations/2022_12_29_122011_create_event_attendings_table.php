<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventAttendingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_attendings', function (Blueprint $table) {
              $table->id();
				$table->unsignedBigInteger('uevent_id');
				$table->unsignedBigInteger('event_id')->nullable();
				$table->unsignedBigInteger('interviewer_id')->nullable();
				$table->string('status',10)->default('1')->nullable();
				$table->string('request',10)->default('0')->nullable();
				$table->text('event_info')->nullable();
				$table->foreign('uevent_id')->references('id')->on('user_events')->onDelete('cascade');
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
        Schema::dropIfExists('event_attendings');
    }
}

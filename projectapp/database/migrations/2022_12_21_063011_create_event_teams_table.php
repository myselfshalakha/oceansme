<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_teams', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('event_id');
		    $table->unsignedBigInteger('user_id');
		    $table->unsignedBigInteger('company_id');
		    $table->unsignedBigInteger('role_id');
			$table->string('islead',10)->default('0')->nullable();
			$table->foreign('event_id')->references('id')->on('events');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('companies');
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
        Schema::dropIfExists('event_teams');
    }
}

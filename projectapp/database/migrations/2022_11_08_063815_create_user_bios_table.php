<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_bios', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('user_id');
			$table->text('hobbies')->nullable();
			$table->text('skills')->nullable();
			$table->text('address')->nullable();
			$table->text('second_address')->nullable();
			$table->text('country')->nullable(); 
			$table->text('state')->nullable();
			$table->text('city')->nullable();
			$table->text('zipcode')->nullable();
			$table->date('birthdate')->nullable();
			$table->text('position')->nullable();
			$table->text('experience')->nullable();
			$table->string('exp_in')->nullable();
			$table->text('qualification')->nullable();
			$table->text('resume')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('user_bios');
    }
}

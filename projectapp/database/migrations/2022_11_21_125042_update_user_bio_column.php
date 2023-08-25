<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserBioColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_bios', function (Blueprint $table) {
            //
			  $table->string('exp_years')->nullable();
			  $table->string('exp_months')->nullable();
			  $table->string('nationality')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_bios', function (Blueprint $table) {
            //
        });
    }
}

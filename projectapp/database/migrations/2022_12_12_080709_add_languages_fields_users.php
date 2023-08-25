<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguagesFieldsUsers extends Migration
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
			$table->text('languages')->after('resume')->nullable();
			$table->string('passport',200)->after('resume')->nullable();
			$table->string('visaStatus',200)->after('resume')->nullable();
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaxminExp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
          $table->text('maxExp')->after('restrictedExperience')->nullable();
          $table->text('minExp')->after('restrictedExperience')->nullable();
          $table->text('minAge')->after('restrictedExperience')->nullable();
          $table->text('maxAge')->after('restrictedExperience')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
}

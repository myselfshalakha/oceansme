<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
			 $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('eventadmin_id');
            $table->unsignedBigInteger('evaluator_id');
			$table->text('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('description');
            $table->text('featured_image')->nullable();
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
        Schema::dropIfExists('events');
    }
}

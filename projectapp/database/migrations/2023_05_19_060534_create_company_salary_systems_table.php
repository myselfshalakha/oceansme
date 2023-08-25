<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanySalarySystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_salary_systems', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('dep_id');
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('company_id');
            $table->string('basic_wage',255)->nullable();
            $table->string('other_contractual',255)->nullable();
            $table->string('guaranteed_wage',255)->nullable();
            $table->string('service_charge',255)->nullable();
            $table->string('additional_bonus',255)->nullable();
            $table->string('bonus_level',255)->nullable();
            $table->string('bonus_personam',255)->nullable();
            $table->string('total_salary',255)->nullable();
            $table->text('incentive_type')->nullable();
            $table->text('contract_length')->nullable();
            $table->text('vacation_month')->nullable();
            $table->string('status',100)->nullable();
            $table->foreign('dep_id')->references('id')->on('departments');
            $table->foreign('post_id')->references('id')->on('posts');
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
        Schema::dropIfExists('company_salary_systems');
    }
}

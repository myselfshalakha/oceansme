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
		
					//	contract_length_loi	salary	min_eng	contract_length	vacation_months	start_up	first_reliever
	//Contract Currency	Seniority	Level Additional Comp	Seniority Range	GROSS TOTAL_updated	

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
            $table->string('min_eng',255)->nullable();
            $table->string('incentive_type',255)->nullable();
            $table->string('contract_length',255)->nullable();
            $table->string('contract_length_loi',255)->nullable();
            $table->string('vacation_month',255)->nullable();
            $table->string('start_up',255)->nullable();
            $table->string('first_reliever',255)->nullable();
            $table->string('contract_currency',255)->nullable();
            $table->string('seniority',255)->nullable();
            $table->string('level_additional_comp',255)->nullable();
			$table->string('seniority_range',255)->nullable();
            $table->string('status',255)->nullable();
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

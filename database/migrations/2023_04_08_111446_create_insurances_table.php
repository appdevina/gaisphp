<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurances', function (Blueprint $table) {
            $table->id();
            $table->string('policy_number');
            $table->string('insured_address')->nullable();
            $table->string('insured_name');
            $table->string('insured_detail')->nullable();
            $table->string('risk_address')->nullable();
            $table->foreignId('stock_inprov_id')->nullable()->unsigned()->references('id')->on('insurance_providers');
            $table->foreignId('building_inprov_id')->nullable()->unsigned()->references('id')->on('insurance_providers');
            $table->bigInteger('stock_worth')->nullable();
            $table->bigInteger('building_worth')->nullable();
            $table->foreignId('insurance_category_id');
            $table->string('extension_of_policy')->nullable();
            $table->dateTime('join_date');
            $table->dateTime('expired_date');
            $table->foreignId('insurance_scope_id');
            $table->foreignId('user_id');
            $table->string('payment_evidence')->nullable();
            $table->string('status')->default('BERJALAN');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insurances');
    }
}

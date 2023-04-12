<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_id');
            $table->string('policy_number');
            $table->foreignId('stock_inprov_id')->nullable()->unsigned()->references('id')->on('insurance_providers');
            $table->foreignId('building_inprov_id')->nullable()->unsigned()->references('id')->on('insurance_providers');
            $table->bigInteger('stock_worth')->nullable();
            $table->bigInteger('building_worth')->nullable();
            $table->string('extension_of_policy')->nullable();
            $table->dateTime('join_date');
            $table->dateTime('expired_date');
            $table->foreignId('user_id');
            $table->string('status')->default('BERJALAN');
            $table->string('payment_evidence')->nullable();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('insurance_updates');
    }
}

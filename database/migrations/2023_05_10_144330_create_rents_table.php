<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->string('rent_code');
            $table->string('rented_address')->nullable();
            $table->string('rented_detail');
            $table->string('first_party');
            $table->string('second_party');
            $table->bigInteger('rent_per_year')->nullable();
            $table->bigInteger('cvcs_fund')->nullable();
            $table->bigInteger('online_fund')->nullable();
            $table->dateTime('join_date');
            $table->dateTime('expired_date');
            $table->string('deduction_evidence')->nullable();
            $table->string('deduction_evidence_file')->nullable();
            $table->string('document')->nullable();
            $table->string('document_file')->nullable();
            $table->string('payment_evidence_file')->nullable();
            $table->string('status')->default('BERJALAN');
            $table->string('month_before_reminder')->nullable();
            $table->foreignId('user_id');
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
        Schema::dropIfExists('rents');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_settings', function (Blueprint $table) {
            $table->id();
            $table->dateTime('request_month')->nullable;
            $table->dateTime('open_date')->nullable;
            $table->dateTime('closed_date')->nullable;
            $table->string('request_detail')->nullable;
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
        Schema::dropIfExists('request_settings');
    }
}

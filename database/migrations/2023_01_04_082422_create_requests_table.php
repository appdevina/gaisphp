<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_code')->nullable();
            $table->foreignId('user_id');
            $table->dateTime('date');
            $table->double('total_cost');
            $table->integer('status_po')->nullable();
            $table->string('po_number')->nullable();
            $table->integer('status_client')->default(0);
            $table->integer('closed_by')->nullable();
            $table->dateTime('closed_at')->nullable();
            // $table->foreignId('approved_by')->nullable();
            // $table->timestamp('approved_at')->nullable();
            $table->foreignId('request_type_id');
            $table->string('request_file')->nullable();
            $table->string('approved_file')->nullable();
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
        Schema::dropIfExists('requests');
    }
}

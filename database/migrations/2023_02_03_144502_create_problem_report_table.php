<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProblemReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problem_report', function (Blueprint $table) {
            $table->id();
            $table->string('problem_report_code')->nullable();
            $table->foreignId('user_id');
            $table->dateTime('date');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('status')->default('PENDING');
            $table->dateTime('scheduled_at')->nullable();
            $table->integer('status_client')->default(0);
            $table->integer('closed_by')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->foreignId('pr_category_id');
            $table->string('result_desc')->nullable();
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
        Schema::dropIfExists('problem_report');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProblemReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('problem_report', function (Blueprint $table) {
            $table->string('photo_before')->nullable()->after('description');
            $table->string('photo_after')->nullable()->after('photo_before');
            $table->string('review_user')->nullable()->after('status_client');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('problem_report', function (Blueprint $table) {
            $table->dropColumn('photo_before');
            $table->dropColumn('photo_after');
            $table->dropColumn('review_user');
        });
    }
}

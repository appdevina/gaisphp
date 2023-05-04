<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterInsuranceTableRev extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('insurances', function (Blueprint $table) {
            $table->dropColumn('policy_number');
            // $table->dropConstrainedForeignId('stock_inprov_id');
            // $table->dropConstrainedForeignId('building_inprov_id');
            $table->dropColumn('stock_worth');
            $table->dropColumn('building_worth');
            $table->dropColumn('extension_of_policy');
            $table->dropColumn('join_date');
            $table->dropColumn('expired_date');
            $table->dropColumn('user_id');
            $table->dropColumn('status');
            $table->dropColumn('payment_evidence');
            $table->dropColumn('actual_stock_worth');
            $table->dropColumn('stock_premium');
            $table->dropColumn('building_premium');
            $table->dropColumn('notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('insurances', function (Blueprint $table) {
        });
    }
}

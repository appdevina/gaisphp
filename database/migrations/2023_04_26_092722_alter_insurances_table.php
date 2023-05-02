<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('insurances', function (Blueprint $table) {
            $table->string('warehouse_code')->nullable()->after('insured_name');
            $table->bigInteger('actual_stock_worth')->nullable()->after('building_worth');
            $table->bigInteger('stock_premium')->nullable()->after('actual_stock_worth');
            $table->bigInteger('building_premium')->nullable()->after('stock_premium');
            $table->string('notes')->nullable()->after('status');
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
            $table->dropColumn('warehouse_code');
            $table->dropColumn('actual_stock_worth');
            $table->dropColumn('stock_premium');
            $table->dropColumn('building_premium');
            $table->dropColumn('notes');
        });
    }
}

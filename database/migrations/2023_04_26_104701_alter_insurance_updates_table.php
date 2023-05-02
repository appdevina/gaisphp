<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterInsuranceUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('insurance_updates', function (Blueprint $table) {
            $table->bigInteger('actual_stock_worth')->nullable()->after('building_worth');
            $table->bigInteger('stock_premium')->nullable()->after('actual_stock_worth');
            $table->bigInteger('building_premium')->nullable()->after('stock_premium');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('insurance_updates', function (Blueprint $table) {
            $table->dropColumn('actual_stock_worth');
            $table->dropColumn('stock_premium');
            $table->dropColumn('building_premium');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShippingTaxFreeDistanceLatitudeLongitudeToConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configs', function (Blueprint $table) {
            $table->decimal('shipping_tax')->default(10);
            $table->integer('free_distance')->default(5000);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configs', function (Blueprint $table) {
            $table->dropColumn('shipping_tax');
            $table->dropColumn('free_distance');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });
    }
}

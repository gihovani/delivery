<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('store');
            $table->string('address')->nullable();
            $table->string('zipcode');
            $table->string('telephone');
            $table->string('google_maps')->nullable();
            $table->boolean('is_open')->default(0);
            $table->integer('waiting_time')
                ->default(\App\Config::DEFAULT_WAITING_TIME);
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
        Schema::dropIfExists('configs');
    }
}

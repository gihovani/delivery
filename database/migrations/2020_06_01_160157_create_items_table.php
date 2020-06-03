<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price')->default(0);
            $table->timestamps();
        });


        Schema::create('item_variation', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('variation_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('item_id')
                ->constrained()
                ->onDelete('cascade');
            $table->unique(['variation_id', 'item_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_product');
        Schema::dropIfExists('items');
    }
}

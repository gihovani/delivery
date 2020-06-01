<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price')->default(0);
            $table->timestamps();
        });


        Schema::create('product_product_item', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('product_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('product_item_id')
                ->constrained()
                ->onDelete('cascade');
            $table->unique(['product_id', 'product_item_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_product_item');
        Schema::dropIfExists('product_items');
    }
}

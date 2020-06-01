<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->foreignId('category_id')
                ->constrained()
                ->onDelete('cascade');
        });

        Schema::create('product_variation', function (Blueprint $table) {
            $table->id();
            $table->decimal('price')->default(0);
            $table->timestamps();

            $table->foreignId('variation_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('product_id')
                ->constrained()
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variation');
        Schema::dropIfExists('variations');
    }
}

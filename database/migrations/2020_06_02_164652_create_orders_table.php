<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('status')
                ->default(\App\Order::STATUS_PENDING);
            $table->decimal('subtotal');
            $table->decimal('discount');
            $table->decimal('shipping_amount');
            $table->decimal('total');
            $table->string('user_name');
            $table->string('user_telephone');
            $table->string('address_zipcode');
            $table->string('address_street')->nullable();
            $table->string('address_number')->nullable();
            $table->string('address_city');
            $table->string('address_state');
            $table->string('address_neighborhood')->nullable();
            $table->string('address_complement')->nullable();
            $table->timestamps();

            $table->foreignId('address_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

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
            $table->timestamp('expected_at')->nullable();
            $table->string('status')
                ->default(\App\Order::STATUS_PENDING);
            $table->string('payment_method')
                ->default(\App\Order::METHOD_SUBSIDIZED);
            $table->decimal('subtotal');
            $table->decimal('amount');
            $table->decimal('additional_amount')->default(0);
            $table->decimal('discount')->default(0);
            $table->decimal('shipping_amount')->default(0);
            $table->decimal('cash_amount')->default(0);
            $table->decimal('back_change')->default(0);
            $table->string('customer_name');
            $table->string('customer_telephone');
            $table->string('deliveryman_name')->nullable();
            $table->string('deliveryman_telephone')->nullable();
            $table->string('address_zipcode')->nullable();
            $table->string('address_street')->nullable();
            $table->string('address_number')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_neighborhood')->nullable();
            $table->string('address_complement')->nullable();
            $table->timestamps();

            $table->foreignId('address_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            $table->foreignId('deliveryman_id')
                ->nullable()
                ->constrained('users')
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

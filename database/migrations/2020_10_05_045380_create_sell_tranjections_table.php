<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellTranjectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_tranjections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sell_id');
            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('image_id');
            $table->string('brand_name',25);
            $table->string('category_name',25);
            $table->string('product_name',25);
            $table->string('product_type',25);
            $table->decimal('purchase_price');
            $table->decimal('selling_price');
            $table->decimal('disc_sell_price')->nullable();
            $table->integer('qty');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('sell_id')->references('id')->on('sells')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sell_tranjections');
    }
}

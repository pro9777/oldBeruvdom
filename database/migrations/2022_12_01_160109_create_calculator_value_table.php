<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculator_value', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('название');
            $table->bigInteger('price')->default(0)->comment('цена');
            $table->bigInteger('final_price')->default(0)->comment('конечная цена');
            $table->bigInteger('old_price')->default(0)->comment('старя цена');
            $table->integer('calculator_group_id')->comment('id группы');
            $table->unsignedBigInteger('product_id')->comment('id товара');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->integer('parent_id')->nullable()->comment('id родителя');
            $table->integer('sort')->nullable()->comment('сортировка');
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
        Schema::dropIfExists('calculator_value');
    }
};

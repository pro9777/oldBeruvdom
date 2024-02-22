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
        Schema::create('calculator_formulas', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->comment('Название');
            $table->string('formula')->comment('Формула');
            $table->unsignedBigInteger('categories_id')->comment('id категории');
            $table->foreign('categories_id')
                ->references('id')
                    ->on('categories')
                ->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->comment('id продукта');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->integer('sort')->default(0)->comment('сортировка');
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
        Schema::dropIfExists('calculator_formula');
    }
};

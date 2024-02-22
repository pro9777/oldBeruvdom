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
        Schema::create('calculator_group', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('название');
            $table->string('name')->comment('название');
            $table->integer('category_id')->comment('id категории');
            $table->integer('product_id')->comment('id товара');
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
        Schema::dropIfExists('calculator_group');
    }
};

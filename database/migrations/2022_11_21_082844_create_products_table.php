<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique()->comment('название');
            $table->string('alias')->unique()->comment('псевдоним');
            $table->integer('price')->comment('цена');
            $table->integer('old_price')->comment('старая цена')->nullable();
            $table->string('brend')->comment('бренд')->nullable();


            $table->integer('parent_id')->nullable()->comment('родительсткая категория');
            $table->string('keywords')->nullable()->comment('ключевые слова');
            $table->string('description')->nullable()->comment('описание');
            $table->integer('sort')->default(0)->comment('сортировка');
            $table->enum('status', ['0', '1'])->default(0)->comment('статус');
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
        Schema::dropIfExists('products');
    }
};

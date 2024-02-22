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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique()->comment('название');
            $table->string('alias')->unique()->comment('псевдоним');
            $table->string('image')->nullable()->comment('фотография');
            $table->integer('parent_id')->nullable()->comment('родительсткая категория');
            $table->string('keywords')->nullable()->comment('ключевые слова');
            $table->string('description')->nullable()->comment('описание');
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
        Schema::dropIfExists('categories');
    }
};

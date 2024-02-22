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
        Schema::create('home', function (Blueprint $table) {
            $table->id();
            $table->string('seo_h1')->nullable()->comment('seo H1');
            $table->string('seo_title')->nullable()->comment('seo название');
            $table->text('seo_description')->nullable()->comment('seo описание');
            $table->string('seo_keywords')->nullable()->comment('seo ключевые слова');
            $table->text('seo_text')->nullable()->comment('seo текст');
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
        Schema::dropIfExists('home');
    }
};

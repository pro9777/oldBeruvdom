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
        Schema::table('products', function (Blueprint $table) {
            $table->enum('hits', [0,1])->nullable()->default(0)->comment('Хиты продаж')->after('sort');
            $table->enum('new', [0,1])->nullable()->default(0)->comment('Новинки')->after('brend');
            $table->string('collection')->nullable()->comment('Коллекция')->after('brend');
            $table->enum('measurement', ['m2','шт','упаковка','комп'])->nullable()->comment('Еденица измерения');
            $table->text('blueprints_text')->nullable()->comment('Текст чертежей')->after('seo_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('hits');
            $table->dropColumn('new');
            $table->dropColumn('collection');
            $table->dropColumn('measurement');
            $table->dropColumn('blueprints_text');
        });
    }
};

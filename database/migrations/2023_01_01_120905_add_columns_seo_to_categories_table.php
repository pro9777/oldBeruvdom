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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('seo_h1')->nullable()->comment('seo H1')->after('sort');
            $table->string('seo_title')->nullable()->comment('seo название')->after('seo_h1');
            $table->string('seo_description')->nullable()->comment('seo описание')->after('seo_title');
            $table->string('seo_keywords')->nullable()->comment('seo ключевые слова')->after('seo_description');
            $table->string('seo_text')->nullable()->comment('seo текст')->after('seo_keywords');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('seo_h1');
            $table->dropColumn('seo_title');
            $table->dropColumn('seo_description');
            $table->dropColumn('seo_keywords');
            $table->dropColumn('seo_text');
        });
    }
};

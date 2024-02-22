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
        Schema::table('calculator_group', function (Blueprint $table) {
            $table->integer('hide')->default(0)->comment('Скрытие блока')->after('default');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calculator_group', function (Blueprint $table) {
            $table->dropColumn('hide');
        });
    }
};

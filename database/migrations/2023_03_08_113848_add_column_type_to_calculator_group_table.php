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
            $table->string('col_outside')->default('6')->comment('Ширина блока')->after('active_slider');
            $table->string('col')->default('12')->comment('Ширина блока')->after('col_outside');
            $table->string('col_inside')->default('3')->comment('Ширина внутреннего блока')->after('col');
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
            $table->dropColumn('col_outside');
            $table->dropColumn('col');
            $table->dropColumn('col_inside');
        });
    }
};

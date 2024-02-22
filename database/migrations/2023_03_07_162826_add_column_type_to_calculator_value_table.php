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
        Schema::table('calculator_value', function (Blueprint $table) {
            $table->enum('default', [0,1,2])->default(0)->comment('выбранный по умолчаю')->after('parent_id');
            $table->enum('active_slider', [0,1,2])->default(0)->comment('связка с слайдером')->after('default');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calculator_value', function (Blueprint $table) {
            $table->dropColumn('default');
            $table->dropColumn('active_slider');
        });
    }
};

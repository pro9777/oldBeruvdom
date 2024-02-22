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
            $table->enum('type', ['radio', 'number'])->default('radio')->after('name');
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
            $table->dropColumn('type');
        });
    }
};

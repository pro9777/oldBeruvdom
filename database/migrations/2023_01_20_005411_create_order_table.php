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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('id_order')->nullable()->comment('id заказа');
            $table->integer('user_id')->nullable()->comment('id пользователя');
            $table->string('name')->comment('имя');
            $table->string('number')->comment('телефон');
            $table->string('email')->nullable()->comment('email');
            $table->string('surname')->nullable()->comment('фамилия')->nullable();
            $table->text('comment')->nullable()->comment('комменатрий')->nullable();
            $table->enum('payment', [0,1,2,3])->default(0)->comment('оплата');
            $table->enum('status', [0,1,2,3,4,5])->default(0)->comment('статус');
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
        Schema::dropIfExists('orders');
    }
};

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
        Schema::create('amocrm', function (Blueprint $table) {
            $table->id();
            $table->text('subdomain')->nullable()->comment('Поддомен');
            $table->text('client_id')->nullable()->comment('ID интеграции');
            $table->text('client_secret')->nullable()->comment('Секретный ключ');
            $table->text('code')->nullable()->comment('Код авторизации (действителен 20 минут)');
            $table->text('redirect_uri')->nullable()->comment('Ссылка для перенаправления');

            $table->text('access_token')->nullable()->comment('Токен для каждого запроса как идентификатор интеграции (действует только сутки)');
            $table->text('refresh_token')->nullable()->comment('Токен для получения нового (access_token)');
            $table->text('token_type')->nullable()->comment('Тип токена');
            $table->text('expires_in')->nullable()->comment('Начало времени токена');
            $table->text('endTokenTime')->nullable()->comment('Конец времени токена');
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
        Schema::dropIfExists('amocrm');
    }
};

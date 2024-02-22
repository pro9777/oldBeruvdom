<?php

namespace App\Orchid\Layouts\Amocrm\Rows;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class AmocrmRows extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Button::make(__('Save'))
                ->type(Color::INFO())
                ->icon('check')
                ->method('createOrUpdateAmocrm'),
            Input::make('amocrm.client_id')->title('ID интеграции'),
            Input::make('amocrm.client_secret')->title('Секретный ключ'),
            Input::make('amocrm.code')->title('Код авторизации (действителен 20 минут)'),
            Input::make('amocrm.redirect_uri')->title('Ссылка на сайт пример (https://beruvdom.ru/)'),
            Input::make('amocrm.access_token')->title('Токен для каждого запроса как идентификатор интеграции (действует только сутки)'),
            Input::make('amocrm.refresh_token')->title('Токен для получения нового (access_token)'),
            Input::make('amocrm.token_type')->title('Тип токена'),
            Input::make('amocrm.expires_in')->title('Начало времени токена'),
            Input::make('amocrm.endTokenTime')->title('Конец времени токена'),
        ];
    }
}

<?php

namespace App\Orchid\Screens\Amocrm;

use App\Http\Requests\AmocrmRequest;
use App\Models\Amocrm\Amocrm;
use App\Orchid\Layouts\Amocrm\Rows\AmocrmRows;
use App\Orchid\Layouts\Amocrm\Rows\AmocrmRows2;
use App\Orchid\Layouts\Home\Rows\HomeRows;
use Carbon\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class AmoCrmScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $amocrm = Amocrm::first();

        $endTokenTime = '';
        if (!empty($amocrm->endTokenTime)){
            $endTokenTime = date("d-m-Y H:i:s", $amocrm->endTokenTime);

        }
        return [
            'amocrm' => $amocrm,
            'amocrm.expires_in2' => $endTokenTime,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'AmoCrm токен';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
//            'systems.history'
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Button::make(__('Save'))
                    ->type(Color::INFO())
                    ->icon('check')
                    ->method('createOrUpdateAmocrm'),
                Input::make('amocrm.subdomain')->title('Поддомен')->help('subdomain')->vertical(),
                Input::make('amocrm.client_id')->title('ID интеграции')->help('client_id'),
                Input::make('amocrm.client_secret')->title('Секретный ключ')->help('client_secret'),
                Input::make('amocrm.code')->title('Код авторизации (действителен 20 минут)')->help('code'),
                Input::make('amocrm.redirect_uri')->type('url')->title('Ссылка на сайт пример (https://beruvdom.ru/)')->help('redirect_uri'),
            ])->title('Обязательные поля'),

            Layout::rows([
                Input::make('amocrm.access_token')->title('Токен для каждого запроса как идентификатор интеграции (действует только сутки)')->help('access_token'),
                Input::make('amocrm.refresh_token')->title('Токен для получения нового (access_token)')->help('refresh_token'),
                Input::make('amocrm.token_type')->title('Тип токена')->help('token_type'),
                Input::make('amocrm.expires_in')->hidden(),
                Input::make('amocrm.expires_in2')->title('Начало времени токена')->help('expires_in'),
//                Input::make('amocrm.endTokenTime')->title('Конец времени токена')->help('endTokenTime'),

            ])->title('Полученные данные после получения токена'),
        ];
    }

    public function createOrUpdateAmocrm(AmocrmRequest $request): void
    {
        Amocrm::updateOrCreate([
            'id' => 1
        ], array_merge($request->validated()['amocrm'], []));


        //добавляем токен или обновляем его если прошло время прошлого токена
        $addRefreshToken = Amocrm::addRefreshToken();

        //
        if (!empty($addRefreshToken)){
            Alert::success($addRefreshToken);
        }

        Toast::success('Сохранено');
    }
}

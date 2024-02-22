<?php

namespace App\Orchid\Screens\Home;

use App\Http\Requests\HomeRequest;
use App\Jobs\ConvertImages;
use App\Models\Home\Home;
use App\Orchid\Layouts\Home\Rows\HomeRows;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class HomeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'home' => Home::find(1)
        ];

    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Главная';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::tabs([
                'Главная' => [HomeRows::class],
//                'Чертежи' => [BlueprintsRows::class],
            ]),

        ];
    }

    public function createOrUpdateHome(HomeRequest $request): void
    {
        $clientId = 1;

        $home = Home::updateOrCreate([
            'id' => $clientId
        ], array_merge($request->validated()['home'], []));

        $home->attachment()->syncWithoutDetaching(
            $request->input('home.attachment', [])
        );
        dispatch(new ConvertImages($home->attachment));

        Toast::info('Обновлено');
    }
}

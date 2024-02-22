<?php

namespace App\Orchid\Screens\Stati;

use App\Http\Requests\StatiRequest;
use App\Jobs\ConvertImages;
use App\Orchid\Layouts\Stati\Rows\StatiSeoRows;
use Illuminate\Http\Request;
use App\Models\Stati;
use App\Orchid\Layouts\Stati\Rows\StatiRows;
use App\Orchid\Layouts\Stati\Table\StatiTable;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class StatiListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'statis' => Stati::filters()
                ->defaultSort('id', 'asc')
                ->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Статьи';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Добавить статью')
                ->modal('modalStati')
                ->method('createOrUpdateStati'),
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
            StatiTable::class,

            Layout::modal('modalStati', Layout::tabs([
                'Статья' => StatiRows::class,
                'Seo' => StatiSeoRows::class
            ])->activeTab('Статья'))
                ->size(Modal::SIZE_LG)
                ->title('статья')
                ->applyButton('сохранить')
                ->async('asyncGetStati'),



        ];
    }

    public function asyncGetStati(Stati $stati): array
    {
        return [
            'stati' => $stati
        ];
    }

    public function createOrUpdateStati(StatiRequest $request): void
    {

        $id = $request->input('stati.id');

        $stati = Stati::updateOrCreate([
            'id' => $id
        ], array_merge($request->validated()['stati'], []));

        $stati->attachment()->syncWithoutDetaching(
            $request->input('stati.attachment', [])
        );
        dispatch(new ConvertImages($stati->attachment));

        is_null($id) ? Toast::info('Статья создана') : Toast::info('Статья обновлена');
    }

    public function statiDelete(Request $request)
    {
        Stati::findOrFail($request->get('id'))->delete();

        Toast::info(__('Удалено'));
    }

    public function statiOffOn(Request $request)
    {
        Stati::where('id', '=', $request->get('id'))
            ->update(['status' => $request->get('stasus')]);
    }

}

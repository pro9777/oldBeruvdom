<?php

namespace App\Orchid\Screens\Page;

use App\Http\Requests\PageRequest;
use App\Http\Requests\StatiRequest;
use App\Jobs\ConvertImages;
use App\Models\Page;
use App\Models\Stati;
use App\Orchid\Layouts\Page\Rows\PageRows;
use App\Orchid\Layouts\Page\Rows\PageSeoRows;
use App\Orchid\Layouts\Page\Table\PageTable;
use App\Orchid\Layouts\Stati\Rows\StatiRows;
use App\Orchid\Layouts\Stati\Rows\StatiSeoRows;
use App\Orchid\Layouts\Stati\Table\StatiTable;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PageListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'page' => Page::filters()
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
        return 'Страницы';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Добавить страницу')
                ->modal('modalPage')
                ->method('createOrUpdatePage'),
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
            PageTable::class,

            Layout::modal('modalPage', Layout::tabs([
                'Статья' => PageRows::class,
                'Seo' => PageSeoRows::class
            ])->activeTab('Статья'))
                ->size(Modal::SIZE_LG)
                ->title('статья')
                ->applyButton('сохранить')
                ->async('asyncGetPage'),
//                ->rawClick(),
        ];
    }

    public function asyncGetPage(Page $page): array
    {
        return [
            'page' => $page
        ];
    }

    public function createOrUpdatePage(PageRequest $request): void
    {

        $id = $request->input('page.id');

        $page = Page::updateOrCreate([
            'id' => $id
        ], array_merge($request->validated()['page'], []));


        $page->attachment()->syncWithoutDetaching(
            $request->input('page.attachment', [])
        );
        dispatch(new ConvertImages($page->attachment));

        is_null($id) ? Toast::info('Страница создана') : Toast::info('Страница обновлена');
    }

    public function pageDelete(Request $request)
    {
        Page::findOrFail($request->get('id'))->delete();

        Toast::info(__('Удалено'));
    }

    public function pageOffOn(Request $request)
    {
        Page::where('id', '=', $request->get('id'))
            ->update(['status' => $request->get('stasus')]);
    }
}

<?php

namespace App\Orchid\Screens\Category;

use App\Http\Requests\CategoryRequest;
use App\Jobs\ConvertImages;
use App\Models\Category;
use App\Models\Product;
use App\Models\Stati;
use App\Orchid\Layouts\Category\CategoryListTable;
use App\Orchid\Layouts\Category\rows\CreateOrUpdate;
use App\Orchid\Layouts\Category\rows\CreateOrUpdateSeo;
use App\Orchid\Layouts\Category\rows\CreateSeo;
use App\Orchid\Layouts\Category\rows\UpdateSeo;
use App\Orchid\Layouts\CreateOrUpdateCategory;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\AsSource;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CategoryListScreen extends Screen
{
    use AsSource;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
//        dd(Stati::whereIn('id', array(1, 2, 3))->get());
        return [
            'categories' => Category::filters()
                ->whereNull('parent_id')
                ->defaultSort('id', 'asc')
                ->paginate(10),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Категории';
    }

    public $description = 'Все категории';


    public function permission(): ?iterable
    {
        return [
            'platform.category'
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Добавить категорию')
                ->modal('createCategory')
                ->method('createOrUpdateCategory '),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [

            //Все сталбцы категории
            CategoryListTable::class,

            //Создание категории в модальном окне
            Layout::modal('createCategory', Layout::tabs([
                'Создание' => CreateOrUpdate::class,
                'Seo категории' => CreateSeo::class
            ])->activeTab('Создание'))
                ->size(Modal::SIZE_LG)
                ->title('Добавление категории')
                ->applyButton('создать'),

            //Обновление товара в модальном окне
            Layout::modal('editCategory', Layout::tabs([
                'Категория' => CreateOrUpdate::class,
                'Seo' => UpdateSeo::class
            ])->activeTab('Категория'))
                ->size(Modal::SIZE_LG)
                ->title('Обновление категории')
                ->applyButton('обновить')
                ->async('asyncGetCategory'),
        ];
    }

    public function asyncGetCategory(Category $category): array
    {
        $stati = '';
        if (!empty($category->stati)){
            $stati = Stati::whereIn('id', json_decode($category->stati))->get();
        }
        return [
            'category' => $category,
            'category.stati' =>  $stati,
        ];
    }

    public function createOrUpdateCategory(CategoryRequest $request): void
    {
        $clientId = $request->input('category.id');

        $category = Category::updateOrCreate([
            'id' => $clientId
        ], array_merge($request->validated()['category'], []));

        $category->attachment()->syncWithoutDetaching(
            $request->input('category.attachment', [])
        );

        dispatch(new ConvertImages($category->attachment));

        is_null($clientId) ? Toast::info('Категория создана') : Toast::info('Категория обновлена');
    }

    public function categoryDelete(Request $request)
    {
        Category::findOrFail($request->get('id'))->delete();

        Toast::info(__('Категория удалена'));
    }

    public function categoryOffOn(Request $request)
    {
        $category_id = $request->get('id');
        $status = $request->get('stasus');
        Category::where('id', '=', $category_id)
            ->update(['status' => $status]);
        Product::where('parent_id', $category_id)
            ->update(['status' => $status]);
    }

}

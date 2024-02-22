<?php

namespace App\Orchid\Screens\Category;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\ProductRequest;
use App\Jobs\ConvertImages;
use App\Models\calculator\CalculatorGroup;
use App\Models\Category;
use App\Models\Product;
use App\Orchid\Layouts\Category\CategoryListTable;
use App\Orchid\Layouts\Category\rows\CreateOrUpdate;
use App\Orchid\Layouts\Category\rows\CreateSeo;
use App\Orchid\Layouts\Category\rows\UpdateSeo;
use App\Orchid\Layouts\Product\ProductListTable;
use App\Orchid\Layouts\Product\rows\ProductCreateOrUpdateRows;
use App\Orchid\Layouts\Product\rows\ProductCreateOrUpdateSeoRows;
use App\Orchid\Layouts\Product\rows\ProductModalCreateOrUpdateRows;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CategoryOrProductScreen extends Screen
{

    /**
     * Query data.
     *
     * @return array
     */

    public function query(Category $category): iterable
    {
        $category_id = $category->id;
        return [

            'categories' => Category::filters()->where('parent_id', '=', $category_id)
                ->defaultSort('id', 'asc')
                ->paginate(10),
            'products' => Product::filters()->where('parent_id', '=', $category_id)
                ->defaultSort('id', 'desc')
                ->paginate(10),
            'calculator_group' => CalculatorGroup::filters()
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
        $category = Category::find(request()->route()->parameters()['category']->id);
        return $category->title;
    }

    public function permission(): ?iterable
    {
        return [
            'platform.category.show'
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        $category = Category::find(request()->route()->parameters()['category']->id);

        return [
            Link::make('Просмотреть')
                ->icon('eye')
                ->target('_blank')
                ->route('category', [
                    'category' => $category->alias,
                ]),
            ModalToggle::make('Добавить категорию')->modal('createCategory')
                ->method('createOrUpdateCategory'),
            ModalToggle::make('Добавить товар')->modal('createProduct')
                ->method('createOrUpdateProduct'),
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

            //Создание категории в модальном окне
            Layout::modal('createCategory', Layout::tabs([
                'Создание категории' => CreateOrUpdate::class,
                'Seo категории' => CreateSeo::class
            ]))->title('Создание категории')
                ->applyButton('создать'),

            //Обновление категории в модальном окне
            Layout::modal('editCategory', Layout::tabs([
                'Категория' => CreateOrUpdate::class,
                'Seo категории' => UpdateSeo::class
            ])->activeTab('Категория'))
                ->title('Обновление категории')
                ->applyButton('обновить')
                ->async('asyncGetCategory'),

            //модальные окно создание товара
            Layout::modal('createProduct', Layout::tabs([
                'Создание совара' => ProductModalCreateOrUpdateRows::class,
                'Seo создание товара' => ProductCreateOrUpdateSeoRows::class
            ]))->title('Добавление товара')
                ->applyButton('создать'),

            //модальные окно обновление товара
            Layout::modal('editProduct', Layout::tabs([
                'Товар' => ProductModalCreateOrUpdateRows::class,
                'Seo товара' => ProductCreateOrUpdateSeoRows::class
            ]))->title('Товар')
                ->applyButton('обновить')
                ->async('asyncGetProduct'),


            //Все сталбцы категории
            Layout::tabs([
                __('Categories') => [CategoryListTable::class],
                __('Products') => [ProductListTable::class],
            ]),


        ];
    }

    public function asyncGetCategory(Category $category): array
    {
        return [
            'category' => $category
        ];
    }

    public function createOrUpdateCategory(Category $category, CategoryRequest $request): void
    {

        $clientId = $request->input('category.id');
        $category_id = $category->id;

        $category = Category::updateOrCreate([
            'id' => $clientId,
            'parent_id' => $category_id
        ], array_merge($request->validated()['category'], []));

        $category->attachment()->syncWithoutDetaching(
            $request->input('category.attachment', [])
        );

        dispatch(new ConvertImages($category->attachment));

        is_null($clientId) ? Toast::info('Категория создана') : Toast::info('Категория обновлена');
    }

    public function asyncGetProduct(Product $product): array
    {
        $product->load('attachment');
        return [
            'product' => $product
        ];
    }

    public function createOrUpdateProduct(Category $category, ProductRequest $request): void
    {
        $clientId = $request->input('product.id');
        $category_id = $category->id;
        $title = $request->input('product.title');
        $alias = $request->input('product.alias');


        $product_arr = $request->product;
        if (empty($alias)) {
            $alias = str_slug($title, '_');
            $product_arr['alias'] = $alias;
            $request->merge([
                'product' => $product_arr,
            ]);
        }
        $product = Product::updateOrCreate([
            'id' => $clientId,
            'parent_id' => $category_id
        ], array_merge($request->validated()['product'], []));


        $product->attachment()->syncWithoutDetaching(
            $request->input('product.attachment', [])
        );

        dispatch(new ConvertImages($product->attachment));

        is_null($clientId) ? Toast::info('товар создан') : Toast::info('Товар обновлен');
    }

    //копировние товара
    public function copyProduct(Category $category, Request $request)
    {
        $product = Product::find($request->id);
        $newProduct = $product->replicate();
        $newProduct->title = $product->title . ' (копия)';
        $newProduct->alias = $product->alias . 'copy';
        $newProduct->measurement = $product->measurement ? $product->measurement : null;

        $newProduct->save();

        Toast::info('товар скопирован');
    }


    public function productСalculator(Request $request)
    {
        CalculatorGroup::findOrFail($request->get('id'))->delete();

        Toast::info(__('Калькулятор удален'));
    }


    public function categoryDelete(Request $request)
    {
        Category::findOrFail($request->get('id'))->delete();

        Toast::info(__('Категория удалена'));
    }

    public function productDelete(Request $request)
    {
        Product::findOrFail($request->get('id'))->delete();

        Toast::info(__('Товар удален'));
    }

    public function categoryOffOn(Request $request)
    {
        Category::where('id', '=', $request->get('id'))
            ->update(['status' => $request->get('stasus')]);
    }

    public function productOffOn(Request $request)
    {
        Product::where('id', '=', $request->get('id'))
            ->update(['status' => $request->get('stasus')]);
    }

    public function hitsOffOn(Request $request)
    {
        Product::where('id', '=', $request->get('id'))
            ->update(['hits' => $request->get('hits')]);
    }

    public function newOffOn(Request $request)
    {
        Product::where('id', '=', $request->get('id'))
            ->update(['new' => $request->get('new')]);
    }


}

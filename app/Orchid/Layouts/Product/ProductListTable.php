<?php

namespace App\Orchid\Layouts\Product;

use App\Models\Category;
use App\Models\Product;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class ProductListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'products';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
//            TD::make('id', 'ID')->cantHide()->sort(),
            TD::make('id', 'ID')->width('20')->render(function (Product $product){
                $category = Category::find(request()->route()->parameters()['category']->id);
                return Link::make($product->id)
                    ->icon('eye')
                    ->target('_blank')
                    ->route('category.product',[
                        'category' => $category->alias,
                        'product' => $product->alias,
                    ]);
            })->sort(),


//            TD::make('id', '')->width('20')->render(function (Product $product){
//                $category = Category::find(request()->route()->parameters()['category']->id);
//                return Link::make()
//                    ->icon('docs')
//                    ->route('category.product',[
//                        'category' => $category->alias,
//                        'product' => $product->alias,
//                    ]);
//            })->sort(),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->render(function (Product $product) {
                    return Button::make(__('копировать'))
                        ->icon('docs')
//                        ->confirm(__($product->id .')Копирование товара: ' . '<br><b>' . $product->title . '</b>'))
                        ->method('copyProduct', [
                            'id' => $product->id,
                        ]);
                }),

            TD::make('title', '')->width('20')->render(function (Product $product){
                return ModalToggle::make()
                    ->modal('editProduct')
                    ->method('createOrUpdateProduct')
                    ->icon('pencil')
                    ->asyncParameters([
                        'product' => $product->id
                    ]);
            })->sort(),
            TD::make('title', 'Название')->width('300'),
            TD::make('title', __('edit'))->render(function (Product $product){
                return Link::make(__('открыть'))
                    ->route('platform.product', [
                        'category' => request()->route()->parameters()['category']->id,
                        'product_id' => $product->id,
                    ])
                    ->icon('folder');
            })->sort(),

            TD::make('alias', 'Ссылка')->cantHide()->filter(TD::FILTER_TEXT)->sort(),

            TD::make('price', 'Цена')->sort(),
            TD::make('price', 'Старая цена')->sort(),
            TD::make('brend', 'Бренд')->sort(),
//            TD::make('created_at', 'Дата создания')->sort()->defaultHidden(),
            TD::make('created_at', __('Дата создания'))
                ->sort()
                ->render(function (Product $product) {
                    return $product->updated_at->toDateTimeString();
                })->defaultHidden(),
            TD::make('updated_at', __('Дата обновления'))
                ->sort()
                ->render(function (Product $product) {
                    return $product->updated_at->toDateTimeString();
                })->defaultHidden(),

            TD::make('hits', 'Хиты продаж')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Product $product) {
                    $hits = $product->hits;
                    return Button::make($hits == '1' ? 'вкл' : 'выкл' )
                        ->type($hits == '1' ? Color::SUCCESS() : Color::DANGER())
                        ->method('hitsOffOn', [
                            'id' => $product->id,
                            'hits' => $hits == '1' ? '0' : '1',
                        ]);
                }),
            TD::make('new', 'Новинки')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Product $product) {
                    $new = $product->new;
                    return Button::make($new == '1' ? 'вкл' : 'выкл' )
                        ->type($new == '1' ? Color::SUCCESS() : Color::DANGER())
                        ->method('newOffOn', [
                            'id' => $product->id,
                            'new' => $new == '1' ? '0' : '1',
                        ]);
                }),
            TD::make('status', 'Статус')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Product $product) {
                    $stasus = $product->status;
                    return Button::make($stasus == '1' ? 'вкл' : 'выкл' )
                        ->type($stasus == '1' ? Color::SUCCESS() : Color::DANGER())
                        ->method('productOffOn', [
                            'id' => $product->id,
                            'stasus' => $stasus == '1' ? '0' : '1',
                        ]);
                }),

            //поля для редактирования
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->render(function (Product $product) {
                    return Button::make(__('удалить'))
                        ->icon('trash')
                        ->confirm(__($product->id .')Удаление: ' . $product->title))
                        ->method('productDelete', [
                            'id' => $product->id,
                        ]);
                })
        ];
    }
}

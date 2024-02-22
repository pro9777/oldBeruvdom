<?php

namespace App\Orchid\Layouts\Category;

use App\Models\Category;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class CategoryListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'categories';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID')
                ->render(function (Category $category){
                    return Link::make($category->id)
                        ->target('_blank')
                        ->icon('eye')
                        ->route('category',$category->alias);
                })->sort(),
            TD::make('title', '')->width('20')->render(function (Category $category){
                return ModalToggle::make()
                    ->modal('editCategory')
                    ->method('createOrUpdateCategory')
                    ->icon('pencil')
                    ->asyncParameters([
                        'product' => $category->id
                    ]);
            })->sort(),

            TD::make('title', 'Название')->width('200'),

            TD::make('alias', 'Url')->cantHide()
                ->render(function (Category $category){
                    return Link::make('открыть')
                        ->route('platform.category', $category->id)
                        ->icon('folder');
                })->filter()->sort(),

            TD::make('alias', 'Ссылка')->cantHide()->filter(TD::FILTER_TEXT)->sort(),

            TD::make('keywords', 'Ключевые слова')->sort()->defaultHidden(),
            TD::make('description', 'Описание')->sort()->defaultHidden(),
            TD::make('created_at', __('Дата создания'))
                ->sort()
                ->render(function (Category $category) {
                    return $category->updated_at->toDateTimeString();
                })->defaultHidden(),
            TD::make('updated_at', __('Дата обновления'))
                ->sort()
                ->render(function (Category $category) {
                    return $category->updated_at->toDateTimeString();
                })->defaultHidden(),
            TD::make()
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Category $category) {
                    $stasus = $category->status;
                    return Button::make($stasus == '1' ? 'вкл' : 'выкл' )
                        ->type($stasus == '1' ? Color::SUCCESS() : Color::DANGER())
                        ->method('categoryOffOn', [
                            'id' => $category->id,
                            'stasus' => $stasus == '1' ? '0' : '1',
                        ]);
                }),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Category $category) {
                    return Button::make(__('удалить'))
                        ->icon('trash')
                        ->confirm(__($category->id .')Удаление: ' . $category->title))
                        ->method('categoryDelete', [
                            'id' => $category->id,
                        ]);
                })
        ];
    }
}

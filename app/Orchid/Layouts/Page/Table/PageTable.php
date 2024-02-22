<?php

namespace App\Orchid\Layouts\Page\Table;

use App\Models\page;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class PageTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'page';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
//            TD::make('id', 'ID')->sort(),
            TD::make('id', 'ID')
                ->render(function (Page $page){
                    return Link::make($page->id)
                        ->target('_blank')
                        ->icon('eye')
                        ->route('page',  $page->alias);
                })->sort(),
            TD::make('id', '')->width('20')->render(function (Page $page){
                return ModalToggle::make()
                    ->modal('modalPage')
                    ->method('createOrUpdatePage')
                    ->icon('pencil')
                    ->asyncParameters([
                        'order' => $page->id
                    ]);
            })->sort(),

            TD::make('title', 'Заголовок')->filter()->sort(),
            TD::make('subtitle', 'Подзаголовок')->filter()->sort()->width(500),
            TD::make()
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (page $page) {
                    $stasus = $page->status;
                    return Button::make($stasus == '1' ? 'вкл' : 'выкл' )
                        ->type($stasus == '1' ? Color::SUCCESS() : Color::DANGER())
                        ->method('pageOffOn', [
                            'id' => $page->id,
                            'stasus' => $stasus == '1' ? '0' : '1',
                        ]);
                }),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_RIGHT)
                ->render(function (page $page) {
                    return Button::make(__('удалить'))
                        ->icon('trash')
                        ->confirm(__($page->id .' - Удаление: ' . $page->title))
                        ->method('pageDelete', [
                            'id' => $page->id,
                        ]);
                }),
        ];
    }
}

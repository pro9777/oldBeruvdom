<?php

namespace App\Orchid\Layouts\Stati\Table;

use App\Models\Stati;
use Orchid\Support\Color;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class StatiTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'statis';

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
                ->render(function (Stati $stati){
                    return Link::make($stati->id)
                        ->target('_blank')
                        ->icon('eye')
                        ->route('statja',  $stati->alias);
                })->sort(),
            TD::make('id', '')->width('20')->render(function (Stati $stati){
                return ModalToggle::make()
                    ->modal('modalStati')
                    ->method('createOrUpdateStati')
                    ->icon('pencil')
                    ->asyncParameters([
                        'order' => $stati->id
                    ]);
            })->sort(),

            TD::make('title', 'Заголовок')->filter()->sort()->width(300),
            TD::make('subtitle', 'Подзаголовок')->filter()->sort()->width(300),
            TD::make()
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Stati $stati) {
                    $stasus = $stati->status;
                    return Button::make($stasus == '1' ? 'вкл' : 'выкл' )
                        ->type($stasus == '1' ? Color::SUCCESS() : Color::DANGER())
                        ->method('statiOffOn', [
                            'id' => $stati->id,
                            'stasus' => $stasus == '1' ? '0' : '1',
                        ]);
                }),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_RIGHT)
                ->render(function (Stati $stati) {
                    return Button::make(__('удалить'))
                        ->icon('trash')
                        ->confirm(__($stati->id .' - Удаление: ' . $stati->title))
                        ->method('statiDelete', [
                            'id' => $stati->id,
                        ]);
                }),
        ];
    }
}

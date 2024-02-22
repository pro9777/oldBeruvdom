<?php

namespace App\Orchid\Layouts\Category;

use App\Models\calculator\CalculatorGroup;
use App\Models\Product;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class   CalculatorListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'calculator_group';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID')->cantHide()->sort(),

            TD::make('title', 'Имя')->render(function (CalculatorGroup $calculatorGroup){
                return ModalToggle::make($calculatorGroup->title)
                    ->modal('editCalculator')
                    ->method('createOrUpdateCalculator')
                    ->asyncParameters([
                        'calculator_group' => $calculatorGroup->id
                    ]);
            }),
            TD::make('name', 'Name')->cantHide()->sort(),
            TD::make('title', 'Редактировать')->cantHide()
                ->render(function (CalculatorGroup $calculatorGroup){
//                    dd(request()->route()->parameters()['product']->id);
                    return Link::make(__('edit'))
                        ->route('platform.category.calculator', [
                            'category' => request()->route()->parameters()['category']->id,
                            'product_id' => request()->route()->parameters()['product']->id,
                            'group_id' => $calculatorGroup->id,
                        ])
                        ->icon('pencil');
                })
                ->filter(TD::FILTER_TEXT)->sort(),
            TD::make('active_slider', 'слайдер')
                ->align(TD::ALIGN_CENTER)
                ->render(function (CalculatorGroup $calculatorGroup) {
                    $stasus = $calculatorGroup->active_slider;
                    return Button::make($stasus == '1' ? 'вкл' : 'выкл' )
                        ->type($stasus == '1' ? Color::SUCCESS() : Color::DANGER())
                        ->method('sliderOffOn', [
                            'id' => $calculatorGroup->id,
                            'status' => $stasus == '1' ? '0' : '1',
                        ]);
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_RIGHT)
                ->render(function (CalculatorGroup $calculatorGroup) {
                    return Button::make(__('удалить'))
                        ->icon('trash')
                        ->confirm(__($calculatorGroup->id .' - Удаление: ' . $calculatorGroup->title))
                        ->method('groupDelete', [
                            'id' => $calculatorGroup->id,
                        ]);
                }),
        ];
    }
}

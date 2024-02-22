<?php

namespace App\Orchid\Layouts\Category;

use App\Models\calculator\CalculatorGroup;
use App\Models\calculator\CalculatorValue;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;

class CalculatorValueListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'calculator_value';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID')->cantHide()->sort(),

            TD::make('title', 'Имя')->render(function (CalculatorValue $calculatorValue){
                return ModalToggle::make($calculatorValue->title)
                    ->modal('editCalculatorValue')
                    ->method('createOrUpdateCalculatorValue')
                    ->asyncParameters([
                        'calculator_group' => $calculatorValue->id
                    ])->icon('pencil');
            }),
            TD::make('alias', 'категория')->cantHide()->sort(),
//            TD::make('title', 'Редактировать')->cantHide()
//                ->render(function (CalculatorValue $calculatorValue){
//                    return Link::make(__('edit'))
//                        ->route('platform.category.calculator.groups', [
//                            'category' => request()->route()->parameters()['category']->id,
//                            'group' => request()->route()->parameters()['calculatorGroup']->id,
//                            'groups' => $calculatorValue->id,
//                        ])
//                        ->icon('pencil');
//                })
//                ->filter(TD::FILTER_TEXT)->sort(),

            TD::make('price', __('price'))->cantHide()->sort(),


            TD::make('default', 'По умолчанию')
                ->align(TD::ALIGN_CENTER)
                ->render(function (CalculatorValue $calculatorValue) {
                    $stasus = $calculatorValue->default;
                    return Button::make($stasus == '1' ? 'вкл' : 'выкл' )
                        ->type($stasus == '1' ? Color::SUCCESS() : Color::DANGER())
                        ->method('defaultOffOn', [
                            'id' => $calculatorValue->id,
                            'status' => $stasus == '1' ? '0' : '1',
                        ]);
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (CalculatorValue $calculatorValue) {
                    return Button::make(__('удалить'))
                        ->icon('trash')
                        ->confirm(__($calculatorValue->id .' - Удаление: ' . $calculatorValue->title))
                        ->method('calculatorValueDelete', [
                            'id' => $calculatorValue->id,
                        ]);
                })
        ];
    }
}

<?php

namespace App\Orchid\Layouts\Product\Calculator\rows;

use App\Models\calculator\CalculatorFormula;
use App\Models\calculator\CalculatorGroup;
use App\Models\Category\CalculatorGroupRelated;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class CalculatorGroupRows extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('calculator_group.id')->type('hidden'),
            Input::make('calculator_group.title')->title('Имя'),
            Input::make('calculator_group.name')->title('Name '),
            Input::make('calculator_group.col_outside')->title('Ширина внешнего блока'),
            Input::make('calculator_group.col')->title('Ширина блока'),
            Input::make('calculator_group.col_inside')->title('Ширина внутренних блоков'),
            CheckBox::make('calculator_group.hide')
                ->value(1)
                ->title('Скрыть блок')
                ->placeholder('Скрыть блок')
                ->help('hide')
                ->sendTrueOrFalse(),
            Select::make('calculator_group.type')
                ->options([
                    'radio'   => 'фото',
                    'number' => 'ввести вручную',
                    'crug' => 'круглое оформление',
                ])
                ->title('Тип поля')
                ->help('Типо поля (Выбрать или ввести вручную цифры)'),
            Select::make('calculator_group.required')
                ->options([
                    '1'   => 'да',
                    '0' => 'нет',
                ])
                ->title('Обящательное поле?')
                ->help('Проверка при добавлении товара в корзину'),
            Input::make('calculator_group.sort')->title('Сортировка'),

        ];
    }
}

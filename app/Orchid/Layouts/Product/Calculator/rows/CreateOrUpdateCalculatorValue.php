<?php

namespace App\Orchid\Layouts\Product\Calculator\rows;

use App\Models\calculator\CalculatorValue;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class CreateOrUpdateCalculatorValue extends Rows
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
            Input::make('calculator_value.id')->type('hidden'),
            Input::make('calculator_value.title')->required()->title(__('name')),
//            Input::make('calculator_value.alias')->required()->title('категория'),
            Input::make('calculator_value.price')->title(__('price')),
            Input::make('calculator_value.final_price')->title(__('конечная цена')),
            Input::make('calculator_value.old_price')->title(__('old_price')),
//            Input::make('calculator_value.parent_id')->required()->title('Родительская категория'),
            Relation::make('parent_id')
                ->fromModel(CalculatorValue::class, 'title')
                ->title('Родительская категория'),

            Upload::make('calculator_value.attachment')
                ->groups('calculator_value')
                ->maxFiles(1)
                ->acceptedFiles('image/*')
                ->storage('calculator_value')
                ->title('Фотография'),
        ];
    }
}

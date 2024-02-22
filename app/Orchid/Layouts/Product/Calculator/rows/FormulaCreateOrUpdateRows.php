<?php

namespace App\Orchid\Layouts\Product\Calculator\rows;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class FormulaCreateOrUpdateRows extends Rows
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
            Input::make('calculator_formula.id')->type('hidden'),
            Input::make('calculator_group.title')->title(''),
            Input::make('calculator_group.formula')->title('Формула'),
        ];
    }
}

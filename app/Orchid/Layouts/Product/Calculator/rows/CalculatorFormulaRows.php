<?php

namespace App\Orchid\Layouts\Product\Calculator\rows;

use App\Models\calculator\CalculatorFormula;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class CalculatorFormulaRows extends Rows
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
            Input::make('calculator_formula_related.id')->type('hidden'),

            TextArea::make('calculator_formula_related.formula')->title('Выбранная формула'),
            Relation::make('calculator_formula.calculator_formula_related')
                ->fromModel(CalculatorFormula::class, 'formula')
                ->applyScope('formula', request()->route()->parameters()['category']->id)
                ->title('Выбрать формулу'),
            Button::make(__('Save'))
                ->type(Color::INFO())
                ->icon('check')
                ->method('createOrUpdateCalculatorFormula'),
        ];
    }
}

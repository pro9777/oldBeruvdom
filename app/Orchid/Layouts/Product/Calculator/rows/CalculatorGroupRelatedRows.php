<?php

namespace App\Orchid\Layouts\Product\Calculator\rows;

use App\Models\calculator\CalculatorGroup;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class CalculatorGroupRelatedRows extends Rows
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
            Relation::make('group_related.')
                ->fromModel(CalculatorGroup::class, 'title')
//                ->applyScope('group', request()->route()->parameters()['category']->id)
                ->applyScope('group')
                ->chunk(999)
                ->multiple()
                ->title('Категории калькулятора'),
            Button::make(__('Save'))
                ->type(Color::SUCCESS())
                ->icon('circle')
                ->method('createOrUpdateGroupRelated'),
        ];
    }
}

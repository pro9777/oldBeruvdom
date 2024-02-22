<?php

namespace App\Orchid\Screens\Product\Calculator;

use App\Models\calculator\CalculatorGroup;
use App\Models\calculator\CalculatorValue;
use App\Models\Category;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class CalculatorValueGrouspListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Category $category,CalculatorGroup $calculatorGroup, CalculatorValue $calculatorValue): iterable
    {
        $calculatorGroup_id = $calculatorGroup->id;
        $parent_id = $calculatorValue->id;
////        dd($calculatorValue);
        return [
            'calculator_value' => CalculatorValue::filters()
                ->where('calculator_group_id', '=', $calculatorGroup_id)
                ->where('parent_id', '=', $parent_id)
                ->defaultSort('id', 'asc')
                ->paginate(10)
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('attributes');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
//            ModalToggle::make('Добавить атрубут')
//                ->modal('createCalculatorValue')
//                ->method('createOrUpdateCalculatorValue'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [

//            //Создание категории в модальном окне
//            Layout::modal('createCalculatorValue', CreateOrUpdateCalculatorValue::class)
//                ->title('Добавление категории')
//                ->applyButton('создать'),
//
//            //Обновление категории в модальном окне
//            Layout::modal('editCalculatorValue', CreateOrUpdateCalculatorValue::class)
//                ->title('Обновление категории')
//                ->applyButton('обновить')
//                ->async('asyncGetCalculatorValue'),
//
//            //Все сталбцы категории
//            CalculatorValueListTable::class,
        ];
    }

    public function asyncGetCalculatorValue(CalculatorValue $calculatorValue): array{
        return [
            'calculator_value' => $calculatorValue
        ];
    }

    public function createOrUpdateCalculatorValue(Category $category, CalculatorGroup $calculatorGroup, CalculatorValue $calculatorValue, Request $request): void
    {

        $id = $request->input('calculator_value.id');
        $title = $request->input('calculator_value.title');
        $price = preg_replace('/[^0-9]/', '', $request->input('calculator_value.price'));
        $old_price = preg_replace('/[^0-9]/', '', $request->input('calculator_value.old_price'));
        $parent_id = request()->route()->parameters()['groups'];
//        dd(request()->route()->parameters()['groups']);
        $request->validate([
            'calculator_value.title' => ['required'],
            'calculator_value.price' => ['required'],
        ]);

        $product = CalculatorValue::updateOrCreate(
            ['id' => $id],
            [
                'title' => $title,
                'price' => $price,
                'old_price' => $old_price,
                'calculator_group_id' => $calculatorGroup->id,
                'parent_id' => $parent_id,
            ]
        );

        $product->attachment()->syncWithoutDetaching(
            $request->input('calculator_value.attachment', [])
        );

        is_null($id) ? Toast::info('товар создан') : Toast::info('Категория обновлена');
    }

    public function calculatorValueDelete(Request $request)
    {
        CalculatorValue::findOrFail($request->get('id'))->delete();

        Toast::info(__('remove'));
    }
}

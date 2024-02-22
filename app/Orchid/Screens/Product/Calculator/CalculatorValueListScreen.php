<?php

namespace App\Orchid\Screens\Product\Calculator;

use App\Jobs\ConvertImages;
use App\Models\calculator\CalculatorGroup;
use App\Models\calculator\CalculatorValue;
use App\Models\Category;
use App\Models\Product;
use App\Orchid\Layouts\Category\CalculatorValueListTable;
use App\Orchid\Layouts\Product\Calculator\rows\CreateOrUpdateCalculatorValue;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CalculatorValueListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Category $category,Product $product, CalculatorGroup $calculatorGroup, CalculatorValue $calculatorValue): iterable
    {
        $parent_id = $calculatorValue->id;

        return [
            'calculator_value' => CalculatorValue::filters()
                ->where('product_id', '=', $product->id)
                ->where('calculator_group_id', '=', $calculatorGroup->id)
                ->where('parent_id', '=', $parent_id)
                ->defaultSort('id', 'asc')
                ->paginate(20)
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

    public function permission(): ?iterable
    {
        return [
            'platform.category.calculator'
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Добавить атрубут')
                ->modal('createCalculatorValue')
                ->method('createOrUpdateCalculatorValue'),
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

            //Создание категории в модальном окне
            Layout::modal('createCalculatorValue', CreateOrUpdateCalculatorValue::class)
                ->title('Добавление категории')
                ->applyButton('создать'),

            //Обновление категории в модальном окне
            Layout::modal('editCalculatorValue', CreateOrUpdateCalculatorValue::class)
                ->title('Обновление категории')
                ->applyButton('обновить')
                ->async('asyncGetCalculatorValue'),

            //Все сталбцы категории
            CalculatorValueListTable::class,
        ];
    }

    public function asyncGetCalculatorValue(CalculatorValue $calculatorValue): array{
        return [
            'calculator_value' => $calculatorValue
        ];
    }

    public function createOrUpdateCalculatorValue(Category $category, Product $product, CalculatorGroup $calculatorGroup, Request $request): void
    {
//        dd($calculatorGroup->id);

        $id = $request->input('calculator_value.id');
        $title = $request->input('calculator_value.title');
        $alias = $request->input('calculator_value.alias');
//        $price = preg_replace('/[^0-9]/', '', $request->input('calculator_value.price'));
        $price = $request->input('calculator_value.price');
        $final_price = preg_replace('/[^0-9]/', '', $request->input('calculator_value.final_price'));
        $old_price = preg_replace('/[^0-9]/', '', $request->input('calculator_value.old_price'));
        if (!$old_price){
            $old_price = 0;
        }
        $calculator_group_id = $calculatorGroup->id;
//        dd($calculatorGroup->id);
        $request->validate([
            'calculator_value.title' => ['required'],
        ]);

        $calculator_value = CalculatorValue::updateOrCreate(
            ['id' => $id],
            [
                'title' => $title,
                'alias' => $alias,
                'price' => $price ? $price : 0,
                'final_price' => $final_price ? $final_price : 0,
                'old_price' => $old_price ? $old_price : 0,
                'calculator_group_id' => $calculator_group_id,
                'product_id' => $product->id,
            ]
        );

        $calculator_value->attachment()->syncWithoutDetaching(
            $request->input('calculator_value.attachment', [])
        );

//        dd($calculator_value->attachment);

        $this->convertImage($calculator_value->attachment);
        is_null($id) ? Toast::info('товар создан') : Toast::info('товар обновлен');
    }

    public function calculatorValueDelete(Request $request)
    {
        CalculatorValue::findOrFail($request->get('id'))->delete();

        Toast::info(__('remove'));
    }

    public function convertImage($images){
        foreach ($images as $item) {
            if ($item->extension != 'webp'){
                dispatch(new ConvertImages($images));
            }
        }
    }

    //По умолчанию выбранный
    public function defaultOffOn(Category $category, Product $product, CalculatorGroup $calculatorGroup, Request $request)
    {
        CalculatorValue::where('product_id', '=', $product->id)
            ->where('calculator_group_id', '=', $calculatorGroup->id)
            ->update(['default' => '0']);

        CalculatorValue::where('id', '=', $request->get('id'))
            ->update(['default' => $request->get('status')]);
    }
}

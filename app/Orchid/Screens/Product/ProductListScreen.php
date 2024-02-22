<?php

namespace App\Orchid\Screens\Product;

use App\Http\Requests\ProductRequest;
use App\Jobs\ConvertImages;
use App\Models\calculator\CalculatorFormula;
use App\Models\calculator\CalculatorFormulaRelated;
use App\Models\calculator\CalculatorGroup;
use App\Models\calculator\CalculatorValue;
use App\Models\Category;
use App\Models\Category\CalculatorGroupRelated;
use App\Models\Product;
use App\Orchid\Layouts\Category\CalculatorListTable;
use App\Orchid\Layouts\Product\Calculator\rows\CalculatorFormulaRows;
use App\Orchid\Layouts\Product\Calculator\rows\CalculatorGroupRelatedRows;
use App\Orchid\Layouts\Product\Calculator\rows\CalculatorGroupRows;
use App\Orchid\Layouts\Product\Calculator\rows\FormulaCreateOrUpdateRows;
use App\Orchid\Layouts\Product\rows\ProductCreateOrUpdateRows;
use App\Orchid\Layouts\Product\rows\ProductCreateOrUpdateSeoRows;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Attachmentable;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class ProductListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Category $category, Product $product): iterable
    {

//        dd($product->measurement);
        //Получить все Категории калькулятора
        $group_related = CalculatorGroupRelated::where('product_id', '=', $product->id)
            ->where('category_id', '=', $category->id)
            ->get();
        //Получить формулу калькулятора
        $calculator_formula_related = CalculatorFormulaRelated::where('product_id', '=', $product->id)->first();

        //массив ids всех выбранных Категории калькулятора
        $group_ids = [];
        foreach ($group_related as $item) {
            $group_ids[] = $item->calculator_group_id;
        }

        //ТАКЖЕ ВАМ МОЖЕТ ПОНАДОБИТЬСЯ:

        $products_like = Product::whereIn('id', json_decode($product->products_like) ?? [])->get();
//        dd(Product::where('id', '=', $product->id)->first());
        return [

            'product' => Product::where('id', '=', $product->id)->first(),

            'group_related' => Product::find($product->id)->calculator_group,
            'calculator_formula_related' => Product::find($product->id)->calculator_formula,
            'product.products_like' =>  $products_like,

            'calculator_group' => CalculatorGroup::filters()
                ->whereIn('id', $group_ids)
                ->defaultSort('id', 'asc')
                ->paginate(10),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        $product = Product::find(request()->route()->parameters()['product']->id);
        return $product->title;
    }

    public function permission(): ?iterable
    {
        return [
            'platform.product'
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        $category = Category::find(request()->route()->parameters()['category']->id);
        $product = Product::find(request()->route()->parameters()['product']->id);
        return [
            Link::make('Просмотреть')
                ->icon('eye')
                ->target('_blank')
                ->route('category.product',[
                    'category' => $category->alias,
                    'product' => $product->alias,
                ]),
            ModalToggle::make('Добавить калькулятор')->modal('createCalculator')
                ->method('createOrUpdateCalculator')
                ->icon('grid')
                ->type(Color::INFO()),

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

            Layout::modal('createCalculator', CalculatorGroupRows::class)->title('Создание калькулятора')
                ->applyButton('создать'),

            Layout::modal('editCalculator', CalculatorGroupRows::class)->title('Обновление калькулятора')
                ->applyButton('обновить')
                ->async('asyncGetCalculator'),

            Layout::modal('createFormula', FormulaCreateOrUpdateRows::class)->title('Создание формулы')
                ->applyButton('создать'),

            Layout::modal('editFormula', FormulaCreateOrUpdateRows::class)->title('Обновление формулы')
                ->applyButton('обновить')
                ->async('asyncGetFormula'),

            Layout::tabs([
                __('Товары') => [
                    Layout::columns([
                        'Левая колонка' => [
                            ProductCreateOrUpdateRows::class,
                        ],
                        'Правая колонка' => [
                            ProductCreateOrUpdateSeoRows::class,
                        ],
                    ])],
                __('calculator') => [
                    CalculatorGroupRelatedRows::class,
                    CalculatorFormulaRows::class,
                    CalculatorListTable::class,
                ],
            ]),


        ];
    }

    public function asyncGetProduct(Product $product): array
    {
        $product->load('attachment');
        return [
            'product' => $product
        ];
    }


    //Создание и обновление товара
    public function createOrUpdateProduct(ProductRequest $request): void
    {

        $clientId = $request->input('product.id');
        $product = Product::updateOrCreate([
            'id' => $clientId
        ], array_merge($request->validated()['product'], []));

        $product->attachment()->syncWithoutDetaching(
            $request->input('product.attachment', [])
        );


        dispatch(new ConvertImages($product->attachment));

//
        is_null($clientId) ? Toast::info('Категория создана') : Toast::info('Товар обновлен');
    }


    public function asyncGetCalculator(CalculatorGroup $calculatorGroup): array
    {
        $calculatorGroup->load('attachment');
//        dd($product);
        return [
            'calculator_group' => $calculatorGroup
        ];
    }


    //добавление и обнововление группы калькулятора
    public function createOrUpdateCalculator(Request $request, Category $category, Product $product): void
    {
        $id = $request->input('calculator_group.id');
        $title = $request->input('calculator_group.title');
        $type = $request->input('calculator_group.type');
        $hide = $request->input('calculator_group.hide');
        $name = $request->input('calculator_group.name');
        $required = $request->input('calculator_group.required');
        $sort = $request->input('calculator_group.sort');
        $col_outside = $request->input('calculator_group.col_outside');
        $col = $request->input('calculator_group.col');
        $col_inside = $request->input('calculator_group.col_inside');
        $product_id = $product->id;
        $category_id = $category->id;

        $calculator_group = $request->calculator_group;
        if (empty($name)) {
            $name = str_slug($title, '_');
            $calculator_group['name'] = $name;
            $request->merge([
                'calculator_group' => $calculator_group,
            ]);
        }

        if (!empty($title)) {
            $request->validate([
                'calculator_group.title' => 'required',
                'calculator_group.name' => [
                    Rule::unique(CalculatorGroup::class, 'name')->ignore($id)
                ],
                'calculator_group.type' => 'string|nullable',
                'calculator_group.category_id' => 'string|nullable',
            ],
                [
                    'calculator_group.name.unique' => 'занято'
                ]);

            CalculatorGroup::updateOrCreate(
                ['id' => $id],
                [
                    'title' => $title,
                    'type' => $type,
                    'hide' => $hide,
                    'col_outside' => $col_outside,
                    'col' => $col,
                    'col_inside' => $col_inside,
                    'product_id' => $product_id,
                    'category_id' => $category_id,
                    'name' => $name,
                    'required' => $required,
                    'sort' => $sort,
                ]
            );

            is_null($id) ? Toast::info('товар создан') : Toast::info('Категория обновлена');
        }

    }

    //копирование значений групп предедущего товара
    public function createOrUpdateGroupRelated(Request $request, Category $category, Product $product): void
    {
        $product_id = $product->id;
        $category_id = $category->id;

        //получаем выбранные группы
        $calculator_group_related = $request->input('group_related');

        //получаем прередущий товар
        $prev_product = Product::where('id', '<', $product_id)
            ->where('parent_id', '=', $category_id)
            ->latest('id')
            ->first();

        if (!empty($calculator_group_related)) {
            if (!empty($prev_product->calculator_group) && empty($product->calculator_group[0]->calculator_value)) {
                //проходимся по группам предедущего товара
                foreach ($calculator_group_related as $group) {
                    foreach ($prev_product->calculator_group as $prev_group) {
                        if ($group == $prev_group->id) {

                            //получаем все значения группы предедущего товара и проходимся по ним
                            foreach ($prev_group->calculator_value()->where('product_id', $prev_product->id)->get() as $value) {

                                $copy_value = $value->replicate()
                                    ->fill(['product_id' => $product->id]);
//                                dd($value->id);
                                if ($copy_value->save()) {
                                    //получаем связь с фотографией у предедущего товара
                                    if (!empty($value->attachment[0])) {
                                        $prev_attachments = $value->attachment[0]->replicate();
                                        $prev_attachments->save();
                                        $copy_value_img = Attachmentable::where('attachmentable_id', '=', $value->id)
                                            ->where('attachmentable_type', '=', 'App\Models\calculator\CalculatorValue')
                                            ->first();
                                        if (!empty($copy_value_img->attachmentable_id)) {
                                            $copy_value_img = $copy_value_img->replicate()
                                                ->fill([
                                                    'attachmentable_id' => $copy_value->id,
                                                    'attachment_id' => $prev_attachments->id
                                                ]);
                                            $copy_value_img->save();
                                        }
                                    }
                                }

                            }
                        }

                    }
                }
            }
        }
        //удаление групп - знчений групп не выбранных
        foreach ($product->calculator_group_related as $product_group_related) {
            $remove = 1;
            if ($calculator_group_related) {
                foreach ($calculator_group_related as $input_group_related) {

                    if ($input_group_related == $product_group_related->calculator_group_id) {
                        $remove = 0;
                    }
                }
            }

            if ($remove) {
                CalculatorGroupRelated::where('calculator_group_id', '=', $product_group_related->calculator_group_id)
                    ->where('product_id', '=', $product_id)
                    ->delete();
                CalculatorValue::where('calculator_group_id', '=', $product_group_related->calculator_group_id)
                    ->where('product_id', '=', $product_id)
                    ->delete();
            }
        }

        //проверяем на пустоту выбранные группы
        if (!empty($calculator_group_related)) {
            //если не пусто значении категорий у перердущего товара
            foreach ($calculator_group_related as $group) {
                //создаем связь группы с товаром
                $add = 1;
                foreach ($product->calculator_group_related as $product_group_related) {
                    if ($group == $product_group_related->calculator_group_id) {
                        $add = 0;
                    }
                }
                if ($add) {
                    CalculatorGroupRelated::create([
                        'calculator_group_id' => $group,
                        'category_id' => $category_id,
                        'product_id' => $product_id,
                    ]);
                }
            }
        }
    }

    //Создание и обновление формулы
    public function createOrUpdateCalculatorFormula(Request $request, Category $category, Product $product): void
    {
        $calculator_formula_id = $request->input('calculator_formula_related.id');
        $formula = $request->input('calculator_formula_related.formula');
        $category_id = $category->id;
        $product_id = $product->id;


        $calculator_formula_related = $request->input('calculator_formula.calculator_formula_related');
        if (!empty($calculator_formula_related)) {
            CalculatorFormulaRelated::where('product_id', '=', $product_id)->delete();

            CalculatorFormulaRelated::create([
                'calculator_formulas_id' => $calculator_formula_related,
                'product_id' => $product_id,
            ]);
            is_null($calculator_formula_id) ? Toast::info('Формула сохранена') : Toast::info('Формула обновлена');
        }

        if (!empty($formula) && empty($calculator_formula_related)) {
            CalculatorFormula::updateOrCreate(
                ['formula' => $formula],
                [
                    'categories_id' => $category_id,
                    'formula' => $formula,
                    'product_id' => $product_id
                ]
            );
            is_null($calculator_formula_id) ? Toast::info('Формула сохранена') : Toast::info('Формула добавлена');
        }
    }

    public function asyncGetCalculatorFormula(Product $product): array
    {
        return [
            'calculator_formula' => $product
        ];
    }

    public function productDelete(Request $request)
    {
        Product::findOrFail($request->get('id'))->delete();

        Toast::info(__('Товар удален'));
    }

    public function groupDelete(Request $request)
    {
        CalculatorValue::where('calculator_group_id', $request->get('id'))->delete();
        CalculatorGroup::findOrFail($request->get('id'))->delete();

        Toast::info(__('Группа удалена'));
    }

    //переключение слайдера
    public function sliderOffOn(Request $request, Category $category, Product $product)
    {

        CalculatorGroup::where('id', '=', $request->get('id'))->update(['active_slider' => $request->get('status')]);

        CalculatorValue::where('product_id', '=', $product->id)
            ->where('calculator_group_id', '=', $request->get('id'))
            ->update(['active_slider' => $request->get('status')]);
    }
}

<?php

namespace App\Orchid\Layouts\Product\rows;

use App\Models\calculator\CalculatorGroup;
use App\Models\Category;
use App\Models\Product;
use App\Models\Stati;
use Nakipelo\Orchid\CKEditor\CKEditor;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class ProductCreateOrUpdateRows extends Rows
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
            Button::make(__('Save'))
                ->type(Color::INFO())
                ->icon('check')
                ->method('createOrUpdateProduct'),

            Input::make('product.id')->type('hidden'),

//
            Group::make([
                Input::make('product.articular')->title('Артикул'),
                CheckBox::make('product.show_price')
                    ->sendTrueOrFalse()
                    ->value(1)
                    ->title('Показать скрыть цену')
                    ->placeholder('Не показывать цену'),

            ]),

            Input::make('product.title')->required()->title('Название'),
            Relation::make('product.parent_id')
                ->fromModel(Category::class, 'title')
                ->chunk(999)
                ->title('Категория'),
            Input::make('product.alias')->title('Ссылка'),

            Group::make([
                Input::make('product.price')
                    ->title('Цена')
                    ->mask([
                        'prefix' => '',
                        'groupSeparator' => '',
                        'digitsOptional' => true,
                    ]),
                Input::make('product.old_price')
                    ->title('Старая цена')
                    ->mask([
                        'prefix' => '',
                        'groupSeparator' => '',
                        'digitsOptional' => true,
                    ]),


                Select::make('product.measurement')
                    ->empty('Не выбрано', 0)
                    ->options([

                        'm2' => 'm2',
                        'шт' => 'шт',
                        'упаковка' => 'упаковка',
                        'комп' => 'комп',
                    ])
                    ->title('Единици измерения')
                    ->help('Единици измерения'),

            ]),

            Group::make([
                Input::make('product.brend')->title('Бренд'),
                Input::make('product.collection')->title('Коллекция'),
            ]),

            Relation::make('product.products_like.')
                ->fromModel(Product::class, 'title')
                ->multiple()
                ->chunk(9999)
                ->title('ТАКЖЕ ВАМ МОЖЕТ ПОНАДОБИТЬСЯ'),

            Upload::make('product.attachment')
                ->groups('product_photo')
                ->maxFiles(1)
                ->acceptedFiles('image/*')
                ->storage('products')
                ->title('Фотография'),

            Upload::make('product.attachment')
                ->groups('product_photo_background')
                ->maxFiles(1)
                ->acceptedFiles('image/*')
                ->storage('products')
                ->title('Фон фотографий'),

            Upload::make('product.attachment')
                ->groups('product_gallery')
                ->acceptedFiles('image/*')
                ->storage('products')
                ->title('Галерея'),

            Group::make([
                Input::make('product.status')->title('Статус'),
                Input::make('product.sort')->title('Сортировка'),

            ]),


            CKEditor::make('product.keywords')->title('Ключевые слова на поиск'),
            CKEditor::make('product.description')->title('Описание'),
//            CKEditor::make('product.description')->title('Описание'),
            CKEditor::make('product.description2')->title('Описание2'),


            Button::make(__('Save'))
                ->type(Color::INFO())
                ->icon('check')
                ->method('createOrUpdateProduct'),

        ];
    }
}

<?php

namespace App\Orchid\Layouts\Product\rows;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class ProductModalCreateOrUpdateRows extends Rows
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

            Input::make('product.id')->type('hidden'),

            Input::make('product.title')->required()->title('Название'),
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
                Input::make('product.brend')->title('Бренд'),
            ]),

//            Matrix::make('options')
//                ->columns([
//                    'Ширина',
//                    'Value',
//                    'Units',
//                ]),

            Upload::make('product.attachment')
                ->groups('product_photo')
                ->maxFiles(1)
                ->acceptedFiles('image/*')
                ->storage('products')
                ->title('Фотография'),

            Upload::make('product.attachment')
                ->groups('product_gallery')
                ->acceptedFiles('image/*')
                ->storage('products')
                ->title('Галерея'),
            Group::make([
                Input::make('product.parent_id')->title('Родительская категория'),
                Input::make('product.status')->title('Статус'),
                Input::make('product.sort')->title('Сортировка'),

            ]),

        ];
    }
}

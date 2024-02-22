<?php

namespace App\Orchid\Layouts\Product\rows;

use Nakipelo\Orchid\CKEditor\CKEditor;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class ProductCreateOrUpdateSeoRows extends Rows
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
            Input::make('product.seo_h1')->title('H1'),
            Input::make('product.seo_title')->title('Title'),
            Input::make('product.seo_description')->title('Description '),
            Input::make('product.seo_keywords')->title('Keywords'),
            Upload::make('product.attachment')
                ->groups('blueprints_gallery')
                ->maxFiles(1)
                ->acceptedFiles('image/*')
                ->storage('category')
                ->title('Фото для блока Чертежи'),

            CKEditor::make('product.blueprints_text')->title('Тест'),
        ];
    }
}

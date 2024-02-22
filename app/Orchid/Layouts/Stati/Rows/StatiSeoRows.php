<?php

namespace App\Orchid\Layouts\Stati\Rows;

use Nakipelo\Orchid\CKEditor\CKEditor;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Layouts\Rows;

class StatiSeoRows extends Rows
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
            Input::make('stati.seo_h1')->title('H1'),
            Input::make('stati.seo_title')->title('Title'),
            Input::make('stati.seo_description')->title('Description '),
            Input::make('stati.seo_keywords')->title('Keywords'),
            CKEditor::make('stati.seo_text')->title('Текст')
        ];
    }
}

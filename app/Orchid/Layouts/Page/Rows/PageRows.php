<?php

namespace App\Orchid\Layouts\Page\Rows;

//use Nakipelo\Orchid\CKEditor\CKEditor;
use Nakipelo\Orchid\CKEditor\CKEditor;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class PageRows extends Rows
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
            Input::make('page.id')->type('hidden'),
            Input::make('page.title')->title('Заголовок'),
            TextArea::make('page.subtitle')->title('Подзаголовок')->rows(5),
            Input::make('page.alias')->title('Ссылка'),
            Upload::make('page.attachment')
                ->groups('stati_photo')
                ->maxFiles(1)
                ->acceptedFiles('image/*')
                ->storage('stati')
                ->title('Фотография'),
//            Quill::make('page.text')->title('Текст')->toolbar(["text", "color", "header", "list", "format",])
            CKEditor::make('page.text')->title('Ссылка'),
        ];
    }
}

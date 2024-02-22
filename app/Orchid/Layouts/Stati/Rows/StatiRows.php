<?php

namespace App\Orchid\Layouts\Stati\Rows;

use Nakipelo\Orchid\CKEditor\CKEditor;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class StatiRows extends Rows
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
            Input::make('stati.id')->type('hidden'),
            Input::make('stati.title')->title('Заголовок'),
            TextArea::make('stati.subtitle')->title('Подзаголовок')->rows(5),
            DateTimer::make('stati.updated_at')
                ->title('Дата'),
            Input::make('stati.alias')->title('Ссылка'),
            Upload::make('stati.attachment')
                ->groups('stati_photo')
                ->maxFiles(1)
                ->acceptedFiles('image/*')
                ->storage('stati')
                ->title('Фотография'),
            CKEditor::make('stati.text')->title('Текст')
        ];
    }
}

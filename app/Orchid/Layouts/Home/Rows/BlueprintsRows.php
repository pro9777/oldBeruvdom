<?php

namespace App\Orchid\Layouts\Home\Rows;

use Nakipelo\Orchid\CKEditor\CKEditor;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class BlueprintsRows extends Rows
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
                ->method('createOrUpdateHome'),

            Upload::make('home.attachment')
                ->groups('blueprints_gallery')
                ->maxFiles(1)
                ->acceptedFiles('image/*')
                ->storage('category')
                ->title('Фотогалерея'),

            CKEditor::make('home.blueprints_text')->title('Тест'),

            Button::make(__('Save'))
                ->type(Color::INFO())
                ->icon('check')
                ->method('createOrUpdateHome'),
        ];
    }
}

<?php

namespace App\Orchid\Layouts\Home\Rows;

use Nakipelo\Orchid\CKEditor\CKEditor;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Color;

class HomeRows extends Rows
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
                ->groups('home_slider')
                ->acceptedFiles('image/*')
                ->storage('category')
                ->title('Слайдер'),

            Upload::make('home.attachment')
                ->groups('home_gallery')
                ->acceptedFiles('image/*')
                ->storage('category')
                ->title('Фотогалерея'),

            Upload::make('home.attachment')
                ->groups('clients_gallery')
                ->acceptedFiles('image/*')
                ->storage('category')
                ->title('Наши клиенты'),

            Input::make('home.seo_h1')->title('seo H1'),
            Input::make('home.seo_title')->title('seo Title'),
            Input::make('home.seo_description')->title('seo Description '),
            Input::make('home.seo_keywords')->title('seo Keywords'),
            CKEditor::make('home.seo_text')->title('Тест'),

            Button::make(__('Save'))
                ->type(Color::INFO())
                ->icon('check')
                ->method('createOrUpdateHome'),


        ];
    }
}

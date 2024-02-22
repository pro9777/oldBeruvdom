<?php

namespace App\Orchid\Layouts\Category\rows;

use App\Models\calculator\CalculatorFormula;
use App\Models\calculator\CalculatorGroup;
use App\Models\Category;
use App\Models\Stati;
use Nakipelo\Orchid\CKEditor\CKEditor;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class CreateOrUpdate extends Rows
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
        return array(
            Input::make('category.id')->type('hidden'),
            Input::make('category.title')->required()->title('Имя'),
            Input::make('category.alias')->title('Ссылка'),

            Relation::make('category.stati.')
                ->fromModel(Stati::class, 'title')
                ->chunk(9999)
                ->multiple()
                ->title('Статьи'),
            Upload::make('category.attachment')
                ->groups('category_photo')
                ->maxFiles(1)
                ->acceptedFiles('image/*')
                ->storage('category')
                ->title('Фотография'),
            Upload::make('category.attachment')
                ->groups('category_gallery')
                ->acceptedFiles('image/*')
                ->storage('category')
                ->title('Фотогалерея'),
            Relation::make('category.parent_id')
                ->fromModel(Category::class, 'title')
                ->chunk(9999)
                ->title('Родительсткая категория'),
            TextArea::make('category.keywords')->title('Ключевые слова')->rows(8),
            Upload::make('category.attachment')
                ->groups('blueprints_gallery')
                ->maxFiles(1)
                ->acceptedFiles('image/*')
                ->storage('category')
                ->title('Фото для блока Чертежи'),

            CKEditor::make('category.blueprints_text')->title('Текст для Чертежи')->value(0),
            CKEditor::make('category.description')->title('Текст'),
        );
    }
}

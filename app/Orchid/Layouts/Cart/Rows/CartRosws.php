<?php

namespace App\Orchid\Layouts\Cart\Rows;

use Intervention\Image\Facades\Image;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Facades\Layout;

class CartRosws extends Rows
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
            Input::make('order.name')->title('Имя'),
            Input::make('order.number')->title('Номер'),
            Input::make('order.email')->title('Email'),
            TextArea::make('order.comment')->title('Комментарий')->rows(5 ),
//            Layout::view('hello'),
//            Image::image('http://beruvdom.test/storage/category/2022/12/25/a16d9ab6d92ea7f846893f236c0074014acf2427.webp')
        );
    }
}

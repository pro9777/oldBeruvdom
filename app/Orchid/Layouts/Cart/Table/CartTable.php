<?php

namespace App\Orchid\Layouts\Cart\Table;

use App\Models\Order;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CartTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'order';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID')->filter()->sort(),


            TD::make('id', '')->width('20')->render(function (Order $order){
                return ModalToggle::make()
                    ->modal('updateOrder')
                    ->method('createOrUpdateCategory')
                    ->icon('pencil')
                    ->asyncParameters([
                        'order' => $order->id
                    ]);
            })->sort(),

            TD::make('name', 'имя')->filter()->sort(),
            TD::make('number', 'номер')->filter()->sort(),
            TD::make('email')->filter()->sort(),
        ];
    }
}

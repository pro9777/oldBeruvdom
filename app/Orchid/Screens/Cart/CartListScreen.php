<?php

namespace App\Orchid\Screens\Cart;

use App\Models\Order;
use App\Orchid\Layouts\Cart\Rows\CartRosws;
use App\Orchid\Layouts\Cart\Table\CartTable;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class CartListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $order = Order::filters()
            ->defaultSort('id', 'asc')
            ->paginate(10);
        return [
            'order' => $order,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Заказы';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.cart'
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            CartTable::class,
            Layout::modal('updateOrder', [CartRosws::class,Layout::view('cart.orders')])
                ->size(Modal::SIZE_LG)
                ->title('обновление заказа')
                ->applyButton('обновить')
                ->async('asyncGetOrder'),
        ];
    }

    public function asyncGetOrder(Order $order): array
    {
        return [
            'order' => $order
        ];
    }
}

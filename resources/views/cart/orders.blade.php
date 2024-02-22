<h4 class="text-center text-black fw-light" data-modal-target="title">Заказанные товары</h4>
<div class="bg-white rounded shadow-sm p-4 py-4 d-flex">



</div>
<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th class="text-start">Фото</th>
            <th class="text-start">Атрибуты</th>
            <th class="text-start">Количество</th>
            <th class="text-start">Цена</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($order['products']))
            @foreach($order['products'] as $product)
                <tr>
                    <td class="text-start  text-truncate " data-column="id" colspan="1">
                        <img class="rounded float-start" style="width: 80px"
                             src="{{$product['attributes']['img']}}"
                             alt="...">
                    </td>
                    <td class="text-start  text-truncate " data-column="email" colspan="1">
                        <div>Цвет стекла: {{$product['attributes']['cvet_stekla']}}</div>
                        <div>Цвет фурнитуры: {{$product['attributes']['cvet_furnitury']}}</div>
                    </td>
                    <td class="text-start  text-truncate " data-column="name" colspan="1">
                        <div>{{$product['qty']}}</div>
                    </td>
                    <td class="text-start  text-truncate " data-column="email" colspan="1">
                        <div>{{$product['price'] * $product['qty']}} ₽</div>
                    </td>
                </tr>
            @endforeach
        @endif


        </tbody>
    </table>
</div>

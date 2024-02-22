@if(!empty($value['from']))
    <h1>{{$value['from']}}</h1>
@endif

@if(!empty($value['name']))
    <p><strong>Имя:</strong> {{ $value['name'] }}</p>
@endif
@if(!empty($value['number']))
    <p><strong>Номер:</strong> {{ $value['number'] }}</p>
@endif
@if(!empty($value['email']))
    <p><strong>Email:</strong> {{ $value['email'] }}</p>
@endif
@if(!empty($value['text']))
    <p><strong>Текс:</strong> {{ $value['text'] }}</p>
@endif

@if(!empty($orders))
    <div class="table-responsive">
        <table class="table" style="width: 100%;max-width: 650px">
            <thead>
            <tr>
                <th class="text-start" style="text-align: right">Фото</th>
                <th class="text-start" style="text-align: right">Атрибуты</th>
                <th class="text-start" style="text-align: right">Количество</th>
                <th class="text-start" style="text-align: right">Цена</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($orders))
                @foreach($orders as $product)
                    <tr>
                        <td class="text-start  text-truncate " data-column="id" colspan="1">
                            <div style="text-align: right;width: 100%">
                                <img class="rounded float-start" style="width: 200px"
                                     src="{{'https://beruvdom.ru/' . $product['attributes']['img']}}"
                                     alt="...">
                            </div>
                        </td>
                        <td class="text-start  text-truncate " data-column="email" colspan="1">
                            @foreach($product->attributes['productAttributes'] as $attribut)
                                <div style="padding-left: 10px; display: flex;justify-content: space-between; width: 100%">
                                    <div>{{$attribut['title']}}:</div>
                                    <div><b style="margin-left: 10px">{{$attribut['value']}}</b></div>
                                </div>
                            @endforeach
                        </td>
                        <td class="text-start  text-truncate " data-column="name" colspan="1">
                            <div style="text-align: right">{{$product['quantity']}}</div>
                        </td>
                        <td class="text-start  text-truncate " data-column="email" colspan="1">
                            <div style="text-align: right">{{$product['price'] * $product['quantity']}} ₽</div>
                        </td>
                    </tr>
                @endforeach
            @endif

            </tbody>
        </table>

        <div style="font-size: 24px;color: #000">Общая цена: {{\Cart::session(Session::get('_token'))->getSubTotal()}}</div>
    </div>
@endif

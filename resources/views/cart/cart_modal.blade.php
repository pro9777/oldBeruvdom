@if(!empty(\Cart::session(session('_token'))->getContent()))
    @foreach(\Cart::session(session('_token'))->getContent() as $cart)
        <div class="basked-left_item">
            <div class="basked-left_item__top">
                <div class="basked-left_item__img">
                    <div class="basked-left_item__img__cont"
                         style="background-image: url('{{$cart->attributes->img}}');">
                    </div>
                </div>

                <div class="basked-left_item__right">
                    <div class="basked-left_item__cont">
                        <div class="basked-left_item__title"><b>{{$cart->name}}</b></div>
                            @if(!empty($cart->attributes['productAttributes']))
                               @foreach($cart->attributes['productAttributes'] as $attribut)
                                <span style="color: #000"><b>{{$attribut['title']}}</b>: {{$attribut['value']}}</span>
                               @endforeach
                            @endif
{{--                        @if(!empty($cart->attributes['cvet_stekla']))--}}
{{--                            <span>Цвет стекла: {{$cart->attributes['cvet_stekla']}}</span>--}}
{{--                        @endif--}}
{{--                        @if(!empty($cart->attributes['cvet_furnitury']))--}}
{{--                            <span>Цвет фурнитуры: {{$cart->attributes['cvet_furnitury']}}</span>--}}
{{--                        @endif--}}
                    </div>
                    <div class="basked-left_item__qty">
                        <div class="number" data-id="{{$cart->id}}">
                            <span class="minus">-</span>
                            <input data-m="modal" name="quantity_product"
                                   class="input quantity_product"
                                   type="number" value="{{$cart->quantity}}"
                                   value="{{$cart->id}}">
                            <span class="plus">+</span>
                        </div>
                        <div class="delete_cart" data-id="{{$cart->id}}">
                            <span>Удалить</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="19"
                                 fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M6.545 0h5.182c.954 0 1.727.773 1.727 1.727v.864h2.591c.954 0 1.728.773 1.728 1.727v1.727c0 .954-.774 1.728-1.727 1.728h-.07l-.794 9.5c0 .954-.774 1.727-1.727 1.727H4.818c-.954 0-1.727-.773-1.724-1.656l-.798-9.571h-.069A1.727 1.727 0 0 1 .5 6.045V4.318c0-.954.773-1.727 1.727-1.727h2.591v-.864C4.818.773 5.591 0 6.545 0ZM4.818 4.318h-2.59v1.727h13.817V4.318H4.818Zm9.425 3.455H4.03l.79 9.5h8.636l.003-.072.785-9.428Zm-2.516-6.046v.864H6.545v-.864h5.182Z"
                                      fill="#D5D5D5"/>
                            </svg>
                        </div>
                    </div>
                    <div class="basked-left_item__prices">
                        <div class="basked-left_item__price"><span>{{$cart->price}}</span> <div style="padding-left: 3px;"> ₽</div></div>
                    </div>
                </div>
            </div>
            <div class="basked-left_item__bottom">
                <div class="basked-left_item__qty">
                    <div class="number" data-id="{{$cart->id}}">
                        <button class="minus">-</button>
                        <input data-m="modal" name="quantity_product"
                               class="input quantity_product"
                               type="number" value="{{$cart->quantity}}"
                               value="{{$cart->id}}">
                        <button class="plus">+</button>
                    </div>
                    <div class="basked-left_item__price"><span>{{$cart->price}}</span> <div style="padding-left: 3px;"> ₽</div></div>
                    <div class="delete_cart" data-id="{{$cart->id}}">
                        <span>Удалить</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="19"
                             fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M6.545 0h5.182c.954 0 1.727.773 1.727 1.727v.864h2.591c.954 0 1.728.773 1.728 1.727v1.727c0 .954-.774 1.728-1.727 1.728h-.07l-.794 9.5c0 .954-.774 1.727-1.727 1.727H4.818c-.954 0-1.727-.773-1.724-1.656l-.798-9.571h-.069A1.727 1.727 0 0 1 .5 6.045V4.318c0-.954.773-1.727 1.727-1.727h2.591v-.864C4.818.773 5.591 0 6.545 0ZM4.818 4.318h-2.59v1.727h13.817V4.318H4.818Zm9.425 3.455H4.03l.79 9.5h8.636l.003-.072.785-9.428Zm-2.516-6.046v.864H6.545v-.864h5.182Z"
                                  fill="#D5D5D5"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

    @endforeach
@else
    <h3 class="cart_not">В корзине пока пусто</h3>
@endif

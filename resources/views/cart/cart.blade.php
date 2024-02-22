@extends('layout')
@section('page-title', 'Корзина')
@section('custom_js')
    <script>
        $(document).ready(function () {

            //валидация формы
            $('.basked-addcart').on('click', function (e) {
                e.preventDefault();
                addOrder()
            })
            function addOrder() {

                let name = $("input[name='name']").val();
                let number = $("input[name='number']").val();
                let email = $("input[name='email']").val();
                let comment = $("textarea[name='comment']").val();


                $.ajax({
                    url: '{{route('addOrder')}}',
                    type: 'POST',
                    data: {
                        'name': name,
                        'number': number,
                        'email': email,
                        'comment': comment,
                        // ids_values: values
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (data) => {
                        $('.basked-left_form__cont input').removeClass('error').addClass('success');
                        if ($.isEmptyObject(data.error)) {
                            ym(87516133,'reachGoal','Basket');
                            chips('Сообщение успешно отправлено', 5000);
                            jQuery('.basked form')[0].reset();
                            window.location.href = "{{route('success')}}";
                        } else {
                            // console.log(data.error);
                            if(data.error == 'time'){
                                chips('Подождите', 'chips--red', 5000);
                            }else{
                                $.each(data.error, function (key, value) {
                                    setTimeout(function () {
                                        $('.basked input[name=' + key + ']').addClass('error').removeClass('success');
                                    }, 150);

                                })
                                $('html').animate({
                                        scrollTop: $('.basked-left_form__cont').offset().top - 150
                                    }, 50 // скорость прокрутки
                                );
                                chips('Заполните обязательные поля', 'chips--red', 5000);
                            }

                        }
                    }
                })
            }
        })
    </script>
@endsection

@section('content')

    <section class="basked">
        <div class="container">
            @if(!empty(Session::get('_token')) && !empty(\Cart::session(Session::get('_token'))->getContent()->count()))
                <form action="">
                    <div class="basked-cont">
                        <div class="basked-left">
                            <div class="basked-title">
                                <div class="title">Корзина</div>
                            </div>
{{--                            <div class="basked-line"></div>--}}
                            <div class="basked-left_items">
                                @foreach(\Cart::session(Session::get('_token'))->getContent() as $cart)
                                    <div class="basked-left_item">
                                        <div class="basked-left_item__top">
                                            <div class="basked-left_item__img">
                                                <div class="basked-left_item__img__cont"
                                                     style="background-image: url('{{$cart->attributes->img}}');">
                                                </div>
                                            </div>

                                            <div class="basked-left_item__right">
                                                <div class="basked-left_item__cont">
                                                    <div class="basked-left_item__title">{{$cart->name}}</div>
                                                    @if(!empty($cart->attributes['productAttributes']))
                                                        @foreach($cart->attributes['productAttributes'] as $attribut)
                                                            <span style="color: #000"><b>{{$attribut['title']}}</b>: {{$attribut['value']}}</span>
                                                        @endforeach
                                                    @endif
                                                </div>

                                                <div class="basked-left_item__qty">
                                                    <div class="number" data-id="{{$cart->id}}">
                                                        <span class="minus">-</span>
                                                        <input data-m="modal" name="quantity_product"
                                                               class="input quantity_product"
                                                               type="number" value="{{$cart->quantity}}"
                                                               placeholder="Количество">
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
                                                    <div class="basked-left_item__price">
                                                        <span>{{$cart->price * $cart->quantity}}</span> ₽
                                                    </div>
                                                    {{--                                            <div class="basked-left_item__oldprice"><span>{{$cart->price}}</span> ₽--}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="basked-left_item__bottom">
                                            <div class="basked-left_item__qty">
                                                <div class="number" data-id="{{$cart->id}}">
                                                    <span class="minus">-</span>
                                                    <input data-m="modal" name="quantity_product"
                                                           class="input quantity_product"
                                                           type="number" value="{{$cart->quantity}}"
                                                           placeholder="Количество">
                                                    <span class="plus">+</span>
                                                </div>
                                                <div class="basked-left_item__prices">
                                                    <div class="basked-left_item__price">
                                                        <span>{{$cart->price * $cart->quantity}}</span> ₽
                                                    </div>
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

                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>

                        <div class="basked-right__cont">
                            <div class="basked-right default">
                                <div class="basked-title">
                                    <div class="title">Итого</div>
                                    <span><span class="basked-total">{{\Cart::session(Session::get('_token'))->getSubTotal()}}</span> ₽</span>
                                </div>
                                <div class="basked-right_line">
                                <span>Товары, <span
                                        class="basked-qty">{{\Cart::session(Session::get('_token'))->getTotalQuantity()}}</span> шт.</span>
                                    <span><span
                                            class="basked-total">{{\Cart::session(Session::get('_token'))->getSubTotal()}}</span> ₽</span>
                                </div>
                                {{--                        <div class="basked-right_line">--}}
                                {{--                            <span>Скидка</span>--}}
                                {{--                            <span>− 438 ₽</span>--}}
                                {{--                        </div>--}}
                                <button class="basked-addcart calculator-addcart">Заказать</button>
                                <div class="privacy-policy">Нажимая на кнопку, вы соглашаетесь с</br>
                                    <a href="{{url("/page/politika-konfidencialnosti")}}"> политикой конфиденциальности</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="basked-left add-order basked-left_form">
                        <div class="basked-title">
                            <div class="title">Данные покупателя</div>
                        </div>
                        <form action="">
                            <div class="basked-left_form__cont">
                                <label class="basked-left_form__lavel">
                                    <span>Имя</span>
                                    <input class="input" name="name" type="text" placeholder="Введите имя" value="">
                                </label>

                                <label class="basked-left_form__lavel">
                                    <span>Номер</span>
                                    <input class="input" name="number" type="tel" placeholder="+7999 999 99 99" value="" >
                                </label>

                                <label class="basked-left_form__lavel">
                                    <span>Email</span>
                                    <input class="input" name="email" type="Email" placeholder="Email"
                                           value="">
                                </label>
                                <label class="basked-left_form__lavel">
                                    <span>Текст</span>
                                    <textarea class="input" name="comment" id="" cols="30" rows="10"
                                              placeholder="Текст"></textarea>
                                </label>

                            </div>

                        </form>
                    </div>
                </form>
            @else
                <div class="basked-title">
                    <div class="title" style="text-align: center;width: 100%">В корзине пока пусто</div>
                </div>
        @endif
    </section>

@endsection

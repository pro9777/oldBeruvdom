@extends('layout')
@section('page-title', $home->seo_title ?? '')
@section('description', $home->seo_description ?? '')
@section('keywords', $home->seo_keywords ?? '')
@section('content')
    <section class="slider">
        <div class="container">
            <div class="slider-cont">
                <div class="slider-items owl-carousel">
                    @foreach($home->attachment as $image)
                        @if($image->group == 'home_slider')
                            <div class="slider-items_item" style="background-image: url('{{$image->relativeUrl}}');">
                                <img src="{{$image->relativeUrl}}" alt="">
                            </div>

                        @endif
                    @endforeach
                </div>

                {{--                <div class="slider-buttons">--}}
                {{--                    <div class="slider-buttons_button">Напольные покрытия</div>--}}
                {{--                    <div class="slider-buttons_button">Душевые ограждения</div>--}}
                {{--                    <div class="slider-buttons_button">Межкомнатные двери</div>--}}
                {{--                    <div class="slider-buttons_button">Скинали</div>--}}
                {{--                </div>--}}
            </div>
        </div>
    </section>

    <section class="info">
        <div class="container">
            <div class="info-cont">
                <div class="info-items info-items1 owl-carousel">
                    <div class="info-items_item">
                        <div class="info-items_item__img" style="background-image: url(../img/icons/icon7.png)">
                            <img src="../img/icons/icon7.png" alt="">
                        </div>
                        <div class="info-items_item__text">Гарантия на продукцию и услуги монтажа</div>
                    </div>
                    <div class="info-items_item">
                        <div class="info-items_item__img" style="background-image: url(../img/icons/icon8.png)">
                            <img src="../img/icons/icon8.png" alt="">
                        </div>
                        <div class="info-items_item__text">Профессиональный монтаж и установка</div>
                    </div>
                    <div class="info-items_item">
                        <div class="info-items_item__img" style="background-image: url(../img/icons/icon6.png)">
                            <img src="../img/icons/icon6.png" alt="">
                        </div>
                        <div class="info-items_item__text">Удобная и быстрая доставка</div>
                    </div>
                    <div class="info-items_item">
                        <div class="info-items_item__img" style="background-image: url(../img/icons/icon4.png)">
                            <img src="../img/icons/icon4.png" alt="">
                        </div>
                        <div class="info-items_item__text">Отправка по всей России</div>
                    </div>
                    <div class="info-items_item">
                        <div class="info-items_item__img" style="background-image: url(../img/icons/icon5.png)">
                            <img src="../img/icons/icon5.png" alt="">
                        </div>
                        <div class="info-items_item__text">Оплата картой или наличными при получении</div>
                    </div>


                </div>

            </div>
        </div>
    </section>
    <div class="container" style="margin-bottom: 60px;padding-top: 10px;">
        {!! $home->seo_text ?? ''!!}
    </div>
    <section class="hits">
        <div class="container">
            <div class="title">Хиты продаж</div>
            <div class="info-cont">
                <div class="hits-items hits-items1 owl-carousel">
                    @foreach($hits as $hit)
                        <div class="hits-items_item data-id" data-id="{{$hit->id}}">
                            <div class="hits-items_item__slider">
                                <a href="{{$hit->category->alias}}/{{$hit->alias}}">
                                    @if(sizeof($hit->attachment()->where('group', 'product_gallery')->get()) && count($hit->attachment()->where('group', 'product_photo_background')->get()) == 0)
                                        @foreach($hit->attachment as $image)
                                            @if($image->group == 'product_gallery')
                                                <div class="hits-items_item__slider__img"
                                                     style="background-image: url('{{$image->relativeUrl}}');">
                                                    <img src="{{$image->relativeUrl}}" alt="">
                                                </div>
                                                @break
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach($hit->attachment as $image)
                                            @if($image->group == 'product_photo')
                                                <div class="hits-items_item__slider__img"
                                                     style="background-image: url('{{$image->relativeUrl}}');">
                                                    <img src="{{$image->relativeUrl}}" alt="">
                                                </div>
                                                @break
                                            @endif
                                        @endforeach
                                    @endif
                                </a>
                            </div>
                            <div class="hits-items_item__bot">
                                <a href="{{$hit->category->alias}}/{{$hit->alias}}"
                                   class="hits-items_item__title">{{$hit->title}}</a>
                                <div class="hits-items_item__subtitle">
                                    <p>Артикул: {{$hit->id}}</p>
                                    @if($hit->brend)
                                        <p>Бренд: {{$hit->brend}}</p>
                                    @endif
                                    @if($hit->collection)
                                        <p>Коллекция {{$hit->collection}}</p>
                                    @endif
                                </div>
                                <div class="hits-items_item__price">
                                    @if(!$hit->show_price)
{{--                                        <span class="add_cart"><img src="../img/icons/basked.png" alt=""></span>--}}
                                        <span class="calculator-addcart add_cart">
                                            <span>в корзину</span>
                                            <img src="../img/icons/busked.png" alt="">
                                        </span>
                                        <div class="hits-items_item__subtitle">
                                            <span>{{$hit->price}} ₽ {{'/' . $hit->measurement ?? ''}}</span>
                                            @if($hit->old_price)
                                                <p><s>{{$hit->old_price}} ₽</s></p>
                                            @endif
                                        </div>
                                    @else
                                        <a href="{{$hit->category->alias}}/{{$hit->alias}}"
                                           class="calculator-addcart calculator-category">Подробнее</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="new">
        <div class="container">
            <div class="title">Новинки</div>
            <div class="new-cont">
                <div class="new-items owl-carousel">

                    @foreach($new as $k => $item)

                        <a href="{{$item->category->alias}}/{{$item->alias}}" class="new-items_item">
                            @if(sizeof($item->attachment()->where('group', 'product_gallery')->get()))
                                @foreach($item->attachment as $image)
                                    @if($image->group == 'product_gallery')
                                        <div class="new-items_item__img"
                                             style="background-image: url('{{$image->relativeUrl}}');">
                                            <img src="{{$image->relativeUrl}}" alt="">
                                        </div>
                                        @break
                                    @endif
                                @endforeach
                            @else
                                @foreach($item->attachment as $image)
                                    @if($image->group == 'product_photo')
                                        <div class="new-items_item__img"
                                             style="background-image: url('{{$image->relativeUrl}}');">
                                            <img src="{{$image->relativeUrl}}" alt="">
                                        </div>
                                        @break
                                    @endif
                                @endforeach
                            @endif


                            <div class="new-items_item__texts">
                                <div class="new-items_item__texts__text">
                                    <span>{{$item->title}}</span>
                                </div>
                                <div class="new-items_item__texts__price">
                                    @if(!empty($item->price))
                                        <span>{{$item->price}}р</span>
                                        @if($item->old_price)
                                            <p><s>{{$item->old_price}} ₽</s></p>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach

                    {{--                    <div class="new-items_item">--}}
                    {{--                        <div class="new-items_item__img" style="background-image: url('../img/new1.png');">--}}
                    {{--                        </div>--}}
                    {{--                        <div class="new-items_item__texts">--}}
                    {{--                            <div class="new-items_item__texts__text">--}}
                    {{--                                <span>Акция</span>--}}
                    {{--                                <p>Скинали -10% от стоимости</p>--}}
                    {{--                            </div>--}}
                    {{--                            <div class="new-items_item__texts__price">--}}
                    {{--                                <span>5700₽</span>--}}
                    {{--                                <p>8000₽</p>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                </div>
            </div>
        </div>
    </section>

    <section class="formBgImage">
        <div class="container">
            <div class="formBgImage-cont">
                <div class="formBgImage-form">
                    <form action="">
                        <div class="formBgImage-form_title">Не смогли подобрать? <br> <span>МЫ ВАМ ПОМОЖЕМ!</span></div>
                        <div class="formBgImage-form_inputs">
                            <div class="formBgImage-form_input">
                                <label class="squareShadowLabel"><span>Имя</span>
                                    <input class="squareShadow" type="text" name="name" placeholder="Введите имя"/>
                                </label>
                            </div>
                            <div class="formBgImage-form_input">
                                <label class="squareShadowLabel"><span>Номер</span>
                                    <input class="squareShadow" type="text" name="number" placeholder="Номер телефона"/>
                                </label>
                            </div>
                        </div>
                        <div class="formBgImage-form_checkbox">
                            <label class="checkboxSmallLabel">
                                <input class="checkboxSmall" type="checkbox" name="consent" checked/><span>Я согласен на обработку моих персоональных данных</span>
                            </label>
                        </div>
                        <div class="formBgImage-form_button">
                            <button class="btnCircle">Получить консультацию</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="action">
        <div class="container">
            <div class="action-line">
                <div class="title"><span>Акция</span> Скидка 10% на межкомнатные двери</div>
                <div class="action-srok">Акция дествует до 31.05.2023</div>
            </div>
            <div class="row action-cont">
                <div class="col-md-4">
                    <div class="action-cont_left">
                        <img src="../img/action1.png" alt="">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="action-cont_right">
                        <img src="../img/action2.png" alt="">
                        <img src="../img/action3.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="info">
        <div class="container">
            <div class="title">Этапы сделки</div>
            <div class="info-cont">
                <div class="info-items info-items2">
                    <div class="info-items_item info-items_item_stages active">
                        <div class="info-items_item__img"
                             style="background-image: url('../img/icons/weewe222.png');"><img
                                src="../img/icons/weewe222.png" alt=""></div>
                        <div class="info-items_item__title">Просчет</div>
                        <div class="info-items_item__text__stages"> После оставленной Вами заявки или звонка менеджеру,
                            Вам делается точный расчет стоимости нашими специалистами, которые консультируют по всем
                            интересующим Вас вопросам, дают рекомендации и обсуждают детали по заявке. После чего Вам
                            отправляется коммерческое предложение.
                        </div>
                    </div>
                    <div class="info-items_item info-items_item_stages">
                        <div class="info-items_item__img"
                             style="background-image: url('../img/icons/icon111z.png');"><img
                                src="../img/icons/icon111z.png" alt=""></div>
                        <div class="info-items_item__title">Замер</div>
                        <div class="info-items_item__text__stages">Выезд замерщика на объект осуществляется с согласием
                            клиента, после предоставления адреса объекта и контактной информации. При себе у специалиста
                            имеется фирменный кейс с образцами стекла и часто используемой фурнитурой. Замер
                            осуществляется специалистом с большим опытом работы высокоточными приборами.
                        </div>
                    </div>
                    <div class="info-items_item info-items_item_stages">
                        <div class="info-items_item__img"
                             style="background-image: url('../img/icons/icon111z1.png');"><img
                                src="../img/icons/icon111z1.png" alt=""></div>
                        <div class="info-items_item__title">Заказ</div>
                        <div class="info-items_item__text__stages">Когда менеджеру приходит информация по замеру,
                            делается окончательный расчет стоимости и дорабатываются детали, при необходимости
                            согласовывается замена фурнитура и/или свет изделия. Вам предоставляется необходимая для Вас
                            информация по спецификации (фото). После чего формируется счет и отправляется Вам.
                        </div>
                    </div>
                    <div class="info-items_item info-items_item_stages">
                        <div class="info-items_item__img"
                             style="background-image: url('../img/icons/icon111.png');"><img
                                src="../img/icons/icon111.png" alt=""></div>
                        <div class="info-items_item__title">Оплата</div>
                        <div class="info-items_item__text__stages">Оплачиваете счет удобным для Вас способом: QR-код, по
                            реквизитам компании, переводом на карту или наличными в салоне. Предоплата 50%-70% для
                            запуска заказа в производство. Оплата предусматривает собой выставление счета на оплату
                            товара и услуг в котором находится вся спецификация товара и данные для оплаты, а так-же
                            памятка покупателя. К счету прилагается договор, в котором также есть условия эксплуатации
                            товара.
                        </div>
                    </div>

                    <div class="info-items_item info-items_item_stages">
                        <div class="info-items_item__img"
                             style="background-image: url('../img/icons/icon9.png');"><img
                                src="../img/icons/icon9.png" alt=""></div>
                        <div class="info-items_item__title">Доставка</div>
                        <div class="info-items_item__text__stages">После изготовления и проверки с вами свяжется
                            менеджер для подтверждения готовности принять товар. Если нет необходимости его хранения на
                            нашем складе, информация передаётся в службу доставки. Дату и время доставки согласовываете
                            непосредственно с экспедитором. По прибытию товара оставляете заявку на монтаж.
                        </div>
                    </div>
                    <div class="info-items_item info-items_item_stages">
                        <div class="info-items_item__img"
                             style="background-image: url('../img/icons/icon10.png');"><img
                                src="../img/icons/icon10.png" alt=""></div>
                        <div class="info-items_item__title">Монтаж</div>
                        <div class="info-items_item__text__stages">Наша компания имеет свой собственный сервисный центр,
                            в который входят только самые квалифицированные мастера с большим опытом работы. Мы
                            постоянно отслеживаем качество работы монтажников и даем гарантию на работы, произведённые
                            нашими мастерами. Подробнее с услугами по монтажу можно ознакомиться
                            <a href="{{url("/page/pamyatka")}}">ТУТ</a></div>
                    </div>

                </div>
                <p id="info-bot_text">После оставленной Вами заявки или звонка
                    менеджеру,
                    Вам делается точный расчет стоимости нашими специалистами, которые консультируют по
                    всем
                    интересующим Вас вопросам, дают рекомендации и обсуждают детали по заявке. После
                    чего Вам
                    отправляется коммерческое предложение.</p>
            </div>
        </div>
    </section>
    <section class="clients">
        <div class="container">
            <div class="title">Наши клиенты</div>
            <div class="row clients-items">
                @foreach($home->attachment as $image)
                    @if($image->group == 'clients_gallery')
                        <div class="col-6 col-md-3 clients-item">
                            <img src="{{$image->relativeUrl}}">
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>


    <section class="slitems">
        <div class="container">
            <div class="title">Фотогалерея</div>
            <div class="slitems-cont owl-carousel">
                @foreach($home->attachment as $image)
                    @if($image->group == 'home_gallery')
                        <div class="slitems-item">
                            <div class="slitems-item_img" style="background-image: url('{{$image->relativeUrl}}');">
                                <img src=".{{$image->relativeUrl}}" alt="">
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <section class="working">
            <div class="container">
                <div class="title">Время работы</div>
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="working-title">Магазин:</div>
                        <div class="working-subtitle">с 10:00 до 20:00 без выходных</div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="working-title">Конструкторское бюро::</div>
                        <div class="working-subtitle">с 10:00 до 18:00 будни</div>
                    </div>
                    <div class="col-md-3">
                        <div class="working-title">Склад::</div>
                        <div class="working-subtitle">с 10:00 до 18:00 будни</div>
                    </div>
                </div>
                <div class="working-map">

                    <div style="position:relative;overflow:hidden;"><a
                            href="https://yandex.ru/maps/org/beru_v_dom/237980524462/?utm_medium=mapframe&utm_source=maps"
                            style="color:#eee;font-size:12px;position:absolute;top:0px;">Беру в Дом</a><a
                            href="https://yandex.ru/maps/213/moscow/category/glass_manufacturing/184107743/?utm_medium=mapframe&utm_source=maps"
                            style="color:#eee;font-size:12px;position:absolute;top:14px;">Стекло, стекольная продукция в
                            Москве</a><a
                            href="https://yandex.ru/maps/213/moscow/category/doors/184107677/?utm_medium=mapframe&utm_source=maps"
                            style="color:#eee;font-size:12px;position:absolute;top:28px;">Двери в Москве</a>
                        <iframe
                            src="https://yandex.ru/map-widget/v1/?ll=37.483550%2C55.842004&mode=poi&poi%5Bpoint%5D=37.480102%2C55.843157&poi%5Buri%5D=ymapsbm1%3A%2F%2Forg%3Foid%3D237980524462&z=16"
                            width="100%" height="400" frameborder="1" allowfullscreen="true"
                            style="position:relative;"></iframe>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </section>

@endsection

@extends('layout')
@if(!empty($product->seo_title))
    @section('page-title', $product->seo_title  ?? '')
@else
    @section('page-title', $product->title . ' – купить в Москве | Интернет-магазин Беру в Дом'  ?? '')
@endif
@if(!empty($product->seo_description	))
    @section('description', $product->seo_description	  ?? '')
@else
    @section('description', $product->title . ' цена от ' . $product->price . ' 🔥 – звоните ☎️ +7 (495) 023-05-15. Купить ' . $category->title . ' - в интернет-магазине Беру в Дом - доставка по Москве и России ' ?? '')
@endif

@section( 'keywords', $product->seo_keywords ?? '')

@section('content')
    <section class="cart">
        <div class="container">
            <div class="cart-cont">
                @if(!empty($product->seo_h1))
                    <h1 class="cart-title" data-id="{{$product->id}}">{{$product->seo_h1}}</h1>
                @endif
                <div class="cart-title cart-title2" id="data-id" data-id="{{$product->id}}">{{$product->title}}</div>
                <div class="row">
                    @php
                        if (!empty($product_photo_background)){
                            $col = '5';
                        }else{
                            $col = '4';
                        }

                    @endphp

                    <div @class([
                        "col-md-$col"
                    ])>
{{--                    <div class="col-md-{{!empty($product_photo_background) ? 5 : }}">--}}
                        <div class="cart-slider">
                            <div class="cart-slider_cont all">
                                <div class="slider slider_bg"
                                     style="background-image: url({{$product_photo_background->relativeUrl ?? ''}})">
                                    <div id="item-box_articul"></div>
                                    <div id="sync1" class="owl-carousel owl-theme one lightgallery">
                                        @if(!empty($product_photo->relativeUrl) && empty($product_photo_background))
                                            <div class="item-box" data-src="{{$product_photo->relativeUrl}}">
                                                <div class="item-box_cont2 @if($product->category->id === 22) hits-items_item__slider__img--contain @endif"
                                                     style="background-image: url('{{$product_photo->relativeUrl}}')">
                                                    <img style="display: none" src="{{$product_photo->relativeUrl}}"
                                                         alt="">
                                                </div>
                                                {!! $product_photo->alt ? '<span class="item-box_articul">' . $product_photo->alt . '</span>' : '<span class="item-box_articul">id- ' . $product->id . '</span>' !!}
                                            </div>
                                        @endif
                                        @foreach($product_gallery as $image)
                                            @if(!empty($product_photo_background->relativeUrl))
                                                <div class="item-box" data-src="{{$image->relativeUrl}}">
                                                    <div class="item-box_cont"
                                                         style="background-image: url('{{$image->relativeUrl}}')"></div>
                                                    <img style="display: none" src="{{$image->relativeUrl}}" alt="">
                                                    <img style="opacity: 0" class="item-box_cont__img"
                                                         src="{{$product_photo_background->relativeUrl}}" alt="">
                                                    {!! $image->alt ? '<span class="item-box_articul">' . $image->alt . '</span>' : '<span class="item-box_articul">id- ' . $product->id . '</span>' !!}
                                                </div>
                                            @else
                                                <div class="item-box" data-src="{{$image->relativeUrl}}">
                                                    <div class="item-box_cont2"
                                                         style="background-image: url('{{$image->relativeUrl}}')">
                                                        <img style="display: none" src="{{$image->relativeUrl}}" alt="">
                                                    </div>
                                                    {!! $image->alt ? '<span class="item-box_articul">' . $image->alt . '</span>' : '<span class="item-box_articul">id- ' . $product->id . '</span>' !!}
                                                </div>
                                            @endif
                                        @endforeach
                                        {{--                                        @foreach($product->attachment as $image)--}}
                                        {{--                                            @if($image->group == 'product_gallery' && $image->relativeUrl)--}}
                                        {{--                                                <div class="item-box" data-src="{{$image->relativeUrl}}">--}}
                                        {{--                                                    @foreach($product->attachment as $image_bg)--}}
                                        {{--                                                        @if($image_bg->group == 'product_photo_background' && $image->relativeUrl)--}}
                                        {{--                                                            <div class="item-box_cont" style="background-image: url('{{$image->relativeUrl}}')"></div>--}}
                                        {{--                                                            <img class="item-box_cont__img" src="{{$image_bg->relativeUrl}}" alt="">--}}
                                        {{--                                                        @break--}}
                                        {{--                                                        @endif--}}
                                        {{--                                                    @endforeach--}}
                                        {{--                                                    <div class="item-box_cont2" style="background-image: url('{{$image->relativeUrl}}')"></div>--}}
                                        {{--                                                </div>--}}
                                        {{--                                            @endif--}}
                                        {{--                                        @endforeach--}}
                                        {{--                                        @foreach($product->attachment as $image)--}}
                                        {{--                                            @if($image->group == 'product_photo' && $image->relativeUrl)--}}
                                        {{--                                                <div style="background-image: url('{{$image->relativeUrl}}')"--}}
                                        {{--                                                     class="item-box" data-src="{{$image->relativeUrl}}">--}}
                                        {{--                                                    <img src="{{$image->relativeUrl}}" alt="">--}}
                                        {{--                                                </div>--}}
                                        {{--                                            @endif--}}
                                        {{--                                        @endforeach--}}
                                        {{--                                        @foreach($product->attachment as $image)--}}
                                        {{--                                            @if($image->group == 'product_gallery')--}}
                                        {{--                                                <div style="background-image: url('{{$image->relativeUrl}}')"--}}
                                        {{--                                                     class="item-box" data-src="{{$image->relativeUrl}}">--}}
                                        {{--                                                    <img src="{{$image->relativeUrl}}" alt="">--}}
                                        {{--                                                </div>--}}
                                        {{--                                            @endif--}}
                                        {{--                                        @endforeach--}}
                                    </div>
                                </div>
                                <div class="slider-two">
                                    <div id="sync2" class="owl-carousel owl-theme two">
                                        @if(empty($product_photo_background))
                                            @foreach($product->attachment as $image)
                                                @if($image->group == 'product_photo')
                                                    <div class="slider-two_cont"
                                                         style="background-image: url('{{$image->relativeUrl}}')">
                                                        <img style="display: none" src="{{$image->relativeUrl}}" alt="">
                                                    </div>

                                                @endif
                                            @endforeach
                                        @endif
                                        @foreach($product->attachment as $image)
                                            @if($image->group == 'product_gallery')
                                                <div class="slider-two_cont"
                                                     style="background-image: url('{{$image->relativeUrl}}')">
                                                    <img style="display: none" src="{{$image->relativeUrl}}" alt="">
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($firstParent == 40 || $firstParent == 19 )

                        @else
                            <div class="cart-text">
                                <div class="cart-content_items">
                                    <ul>
                                        <li>
                                            <a href="{{url("/page/pamyatka")}}">
                                                <img src="../img/pamyatka.png" alt="">
                                            </a>
                                            <a href="{{url("/page/pamyatka")}}">Памятка покупателя</a>
                                        </li>
                                        <li>
                                            <a href="{{url("/page/montaz")}}">
                                                <img src="../img/ustanovka.png" alt="">
                                            </a>
                                            <a href="{{url("/page/montaz")}}">Монтаж</a>
                                        </li>
                                    </ul>
                                </div>
                                @if($product->parent_id != 26)
                                    {!! $product->description !!}
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="col-md-{{!empty($product_photo_background) ? 7 : 8}}">
                        <div class="calculator">
                            <div class="row">
                                <div class="col-12">
                                    @if(!empty($product->keywords))
                                        {!! $product->keywords !!}
                                    @endif
                                </div>
                            </div>

                            @if($product->parent_id == 26)
                                {!! $product->description !!}
                            @endif
                            <div class="row calculator-top">
                                <div class="col-md-12">
                                    {{--                                    <div class="calculator-title">Впишите размеры стекла</div>--}}
                                    <div class="calculator-item">
                                        <div class="mcalculator-sizes">
                                            <div class="row calculator-sizes_items justify-content-center">
                                                @foreach($product->calculator_group()->orderBy('sort')->get() as $calculator)
                                                    @php
                                                        $isActive = false;
                                                        if(!empty($calculator->hide)){
                                                            $isActive = true;
                                                        }

                                                    @endphp


                                                    {{--                                                    <div class="col-12 col-md-12 col-lg-{{$calculator->col_outside}}">--}}
                                                    <div @class([
                                                        'col-12',
                                                        'col-md-12',
                                                        'col-lg-' . $calculator->col_outside,
                                                        'd-none' => $isActive,
                                                    ])>

                                                        <div class="row justify-content-center 333">
                                                            <div class="col-md-{{$calculator->col}}">
                                                                <div class="calculator-title"
                                                                     data-group="{{$calculator->id}}">{{$calculator->title}}</div>
                                                                <div class="row justify-content-center control"
                                                                     data-r="{{$calculator->required}}"
                                                                     data-name="{{$calculator->name}}">
                                                                    @foreach($calculator->calculator_value()->where('product_id', $product->id)->get() as $k => $calculator_value)
                                                                        @if($calculator->type != 'number')
                                                                            <div
                                                                                class="col-4 col-sm-3 col-md-3 col-lg-{{$calculator->col_inside}}">
                                                                                <div class="calculator-item">
                                                                                    <label
                                                                                        class="calculator-item_label {{$calculator->type == 'crug' ? 'calculator-item_label__crug' : ''}} {{$calculator->active_slider ? 'active_slider' : ''}} {{$calculator->name}}"
                                                                                        data-id_slider="{{$k + 1 }}">
                                                                                        <input class="radio"
                                                                                               type="radio"
                                                                                               name="{{$calculator->name}}"
                                                                                               data-id="{{$calculator_value->id}}"
                                                                                               data-name="{{$calculator->name}}"
                                                                                               value="{{$calculator_value->title}}"
                                                                                               data-title="{{$calculator->title}}"
                                                                                            {{$calculator_value->default ? 'checked' : ''}}>
                                                                                        @if($calculator->type == 'crug')
                                                                                            <div
                                                                                                class="calculator-item_img calculator-item_img__crug">{{$calculator_value->title}}</div>
                                                                                        @else
                                                                                            <div
                                                                                                class="calculator-item_img"
                                                                                                style="background-image: url('{{$calculator_value->attachment[0]->relativeUrl ?? 'no_image.jpg'}}');">
                                                                                                <img
                                                                                                    src="{{$calculator_value->attachment[0]->relativeUrl ?? 'no_image.jpg'}}"
                                                                                                    alt="">
                                                                                            </div>
                                                                                        @endif

                                                                                    </label>
                                                                                    @if($calculator->type != 'crug')
                                                                                        <p>{{$calculator_value->title}}</p>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                            <div
                                                                                class="col-6 col-sm-6 col-lg-{{$calculator->col_inside}}">
                                                                                <div
                                                                                    class="calculator-sizes_item control"
                                                                                    data-name="{{$calculator->name}}"
                                                                                    data-value="{{$calculator_value->id}}"
                                                                                    data-r="{{$calculator->required}}">

                                                                                    <div
                                                                                        class="calculator-sizes_item__input">
                                                                                        <input
                                                                                            class="input {{$calculator->name}}"
                                                                                            type="number"
                                                                                            name="{{$calculator->name}}"
                                                                                            placeholder="{{$calculator_value->title}} в см"
                                                                                            data-id="{{$calculator_value->id}}"
                                                                                            data-name="{{$calculator->name}}"
                                                                                            data-title="{{$calculator->title}}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="calculator-bot_cont data-id" data-id="{{$product->id}}">
                                <div class="calculator-bot">
                                    <div class="calculator-bot_head d-none">
                                        <ul>
                                            <li>
                                                <b>Необходимо:</b>
                                                <span class="metersSquared">0 м2</span>
                                            </li>
                                            <li>
                                                <b>Количество:</b>
                                                <span class="numberOfPackages">0 упак.</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="calculator-bot_bottom">
                                        <div class="calculator-bot_cont">
                                            <div class="calculator-totalprice"><span>{{$product->price}}</span>р
                                            </div>
                                            <div class="number">
                                                <span class="minus">-</span>
                                                <input name="quantity_product" class="input quantity_product"
                                                       type="number"
                                                       value="1" placeholder="Количество">
                                                <span class="plus">+</span>
                                            </div>
                                        </div>
                                        <button class="calculator-addcart add_to_cart">
                                            <span>в корзину</span>
                                            <img style="display: block" src="../img/icons/busked.png" alt="">
                                        </button>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="cart-content"></div>
                        <div class="row cart-blueprints">
                            <div class="col-md-6">
                                @foreach($product->attachment as $image)
                                    @if($image->group == 'blueprints_gallery')
                                        <img src="{{$image->relativeUrl}}" alt="">
                                    @endif
                                @endforeach
                            </div>
                            @if(!empty($product->blueprints_text))
                                <div class="col-md-6 cart-blueprints_right more more2">{!! $product->blueprints_text !!}
                                    <span class="more_open">еще...</span></div>

                            @endif
                        </div>


                    </div>
                    <section class="formBgImage">
                        <div class="formBgImage-cont">
                            <div class="formBgImage-form">
                                <form action="">
                                    <div class="formBgImage-form_title">Не смогли подобрать? <br>
                                        <span>МЫ ВАМ ПОМОЖЕМ!</span></div>
                                    <div class="formBgImage-form_inputs">
                                        <div class="formBgImage-form_input">
                                            <label class="squareShadowLabel"><span>Имя</span>
                                                <input class="squareShadow" type="text" name="name"
                                                       placeholder="Введите имя"/>
                                            </label>
                                        </div>
                                        <div class="formBgImage-form_input">
                                            <label class="squareShadowLabel"><span>Номер</span>
                                                <input class="squareShadow" type="text" name="number"
                                                       placeholder="Номер телефона"/>
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
                    </section>
                    <section class="info">
                        <div class="">
                            <div class="title">Этапы сделки</div>
                            <div class="info-cont">
                                <div class="info-items info-items2">
                                    <div class="info-items_item info-items_item_stages active">
                                        <div class="info-items_item__img"
                                             style="background-image: url('../img/icons/weewe222.png');"><img
                                                src="../img/icons/weewe222.png" alt=""></div>
                                        <div class="info-items_item__title">Просчет</div>
                                        <div class="info-items_item__text__stages"> После оставленной Вами заявки или
                                            звонка менеджеру,
                                            Вам делается точный расчет стоимости нашими специалистами, которые
                                            консультируют по всем
                                            интересующим Вас вопросам, дают рекомендации и обсуждают детали по заявке.
                                            После чего Вам
                                            отправляется коммерческое предложение.
                                        </div>
                                    </div>
                                    <div class="info-items_item info-items_item_stages">
                                        <div class="info-items_item__img"
                                             style="background-image: url('../img/icons/icon111z.png');"><img
                                                src="../img/icons/icon111z.png" alt=""></div>
                                        <div class="info-items_item__title">Замер</div>
                                        <div class="info-items_item__text__stages">Выезд замерщика на объект
                                            осуществляется с согласием
                                            клиента, после предоставления адреса объекта и контактной информации. При
                                            себе у специалиста
                                            имеется фирменный кейс с образцами стекла и часто используемой фурнитурой.
                                            Замер
                                            осуществляется специалистом с большим опытом работы высокоточными приборами.
                                        </div>
                                    </div>
                                    <div class="info-items_item info-items_item_stages">
                                        <div class="info-items_item__img"
                                             style="background-image: url('../img/icons/icon111z1.png');"><img
                                                src="../img/icons/icon111z1.png" alt=""></div>
                                        <div class="info-items_item__title">Заказ</div>
                                        <div class="info-items_item__text__stages">Когда менеджеру приходит информация
                                            по замеру,
                                            делается окончательный расчет стоимости и дорабатываются детали, при
                                            необходимости
                                            согласовывается замена фурнитура и/или свет изделия. Вам предоставляется
                                            необходимая для Вас
                                            информация по спецификации (фото). После чего формируется счет и
                                            отправляется Вам.
                                        </div>
                                    </div>
                                    <div class="info-items_item info-items_item_stages">
                                        <div class="info-items_item__img"
                                             style="background-image: url('../img/icons/icon111.png');"><img
                                                src="../img/icons/icon111.png" alt=""></div>
                                        <div class="info-items_item__title">Оплата</div>
                                        <div class="info-items_item__text__stages">Оплачиваете счет удобным для Вас
                                            способом: QR-код, по
                                            реквизитам компании, переводом на карту или наличными в салоне. Предоплата
                                            50%-70% для
                                            запуска заказа в производство. Оплата предусматривает собой выставление
                                            счета на оплату
                                            товара и услуг в котором находится вся спецификация товара и данные для
                                            оплаты, а так-же
                                            памятка покупателя. К счету прилагается договор, в котором также есть
                                            условия эксплуатации
                                            товара.
                                        </div>
                                    </div>

                                    <div class="info-items_item info-items_item_stages">
                                        <div class="info-items_item__img"
                                             style="background-image: url('../img/icons/icon9.png');"><img
                                                src="../img/icons/icon9.png" alt=""></div>
                                        <div class="info-items_item__title">Доставка</div>
                                        <div class="info-items_item__text__stages">После изготовления и проверки с вами
                                            свяжется
                                            менеджер для подтверждения готовности принять товар. Если нет необходимости
                                            его хранения на
                                            нашем складе, информация передаётся в службу доставки. Дату и время доставки
                                            согласовываете
                                            непосредственно с экспедитором. По прибытию товара оставляете заявку на
                                            монтаж.
                                        </div>
                                    </div>
                                    <div class="info-items_item info-items_item_stages">
                                        <div class="info-items_item__img"
                                             style="background-image: url('../img/icons/icon10.png');"><img
                                                src="../img/icons/icon10.png" alt=""></div>
                                        <div class="info-items_item__title">Монтаж</div>
                                        <div class="info-items_item__text__stages">Наша компания имеет свой собственный
                                            сервисный центр,
                                            в который входят только самые квалифицированные мастера с большим опытом
                                            работы. Мы
                                            постоянно отслеживаем качество работы монтажников и даем гарантию на работы,
                                            произведённые
                                            нашими мастерами. Подробнее с услугами по монтажу можно ознакомиться
                                            <a href="{{url("/page/montaz")}}">ТУТ</a></div>
                                    </div>

                                </div>
                                <p id="info-bot_text" class="more">После оставленной Вами заявки или звонка
                                    менеджеру,
                                    Вам делается точный расчет стоимости нашими специалистами, которые консультируют по
                                    всем
                                    интересующим Вас вопросам, дают рекомендации и обсуждают детали по заявке. После
                                    чего Вам
                                    отправляется коммерческое предложение. <span class="more_open">еще...</span></p>
                            </div>
                        </div>
                    </section>
                    <div class="cart-content">
                        <div class="title">Описание</div>
                        <div id="info-bot_text">{!! $product->description2 !!}</div>
                    </div>
                    @if(is_countable($products_like) && count($products_like) > 0)
                        <div class="cart-content">
                            <div class="title">ТАКЖЕ ВАМ МОЖЕТ ПОНАДОБИТЬСЯ:</div>
                            <div class="info-cont">
                                <div class="row hits-items">
                                    @foreach($products_like as $item)
                                        @if(!empty($item->category))
                                            <div class="col-6 col-md-3 hits-items_item2 data-id"
                                                 data-id="{{$item->id}}">
                                                <div class="hits-items_item2_cont">
                                                    <a href="{{$item->category->alias}}/{{$item->alias}}">
                                                        <div class="hits-items_item__slider hits-items_item__slider_t">
                                                            @foreach($item->attachment as $image)
                                                                @if($image->group == 'product_photo')
                                                                    <div class="hits-items_item__slider__img"
                                                                         style="background-image: url('{{$image->relativeUrl}}');">
                                                                        <img src="{{$image->relativeUrl}}" alt="">
                                                                        @foreach($item->attachment as $image)
                                                                            @if($image->group == 'product_gallery')
                                                                                <div
                                                                                    class="hits-items_item__slider__img2"
                                                                                    style="background-image: url('{{$image->relativeUrl}}');">
                                                                                    <img src="{{$image->relativeUrl}}"
                                                                                         alt="">
                                                                                </div>
                                                                                @break
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="hits-items_item__bot">
                                                            <a href="{{$item->category->alias}}/{{$item->alias}}"
                                                               class="hits-items_item__title">{{$item->title}}</a>
                                                            <div class="hits-items_item__subtitle">
                                                                <p>Артикул: {{$item->id}}</p>
                                                                @if($product->brend)
                                                                    <p>Бренд: {{$item->brend}}</p>
                                                                @endif
                                                                @if($item->collection)
                                                                    <p>Коллекция {{$item->collection}}</p>
                                                                @endif
                                                            </div>
                                                            <div class="hits-items_item__price">
                                                                @if($item->price)
                                                                    <span class="calculator-addcart add_cart">
                                                                        <span>в корзину</span>
                                                                        <img src="../img/icons/busked.png" alt="">
                                                                    </span>
                                                                    <div class="hits-items_item__subtitle">
                                                                        <span>{{$item->price}} ₽ {{'/' . $item->measurement ?? ''}}</span>
                                                                        @if($item->old_price)
                                                                            <p><s>{{$item->old_price}}
                                                                                    ₽</s></p>
                                                                        @endif
                                                                    </div>
                                                                @else
                                                                    <a href="{{$item->category->alias}}/{{$item->alias}}"
                                                                       class="calculator-addcart calculator-category">рассчитать</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>

@endsection

@section('')
    <script>
        $(document).ready(function () {

        })
    </script>
@endsection

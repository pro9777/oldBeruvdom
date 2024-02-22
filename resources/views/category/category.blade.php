@extends('layout')

@if(!empty($category->seo_title))
    @section('page-title', $category->seo_title)
@else
    @section('page-title', $category->title . ' – купить в Москве | Интернет-магазин Беру в Дом ' ?? '')
@endif

@if(!empty($category->seo_description	))
    @section('description', $category->seo_description	  ?? '')
@else
    @section('description', $category->title . ' – в интернет-магазине Беру в Дом - доставка по Москве и России. Звоните ☎️ +7 (495) 023-05-15. Шоурум и магазин в Москве!' ?? '')
@endif
@section( 'keywords', $category->seo_keywords ?? '')

@section('content')
    @if($category->id == 53)
        <section class="imgtext">
            <div class="container">
                <div class="imgtext-cont">
                    <div class="imgtext-img">
                        <img src="./img/img333.png" alt="">
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($category->id == 48)
        <section class="imgtext">
            <div class="container">
                <div class="imgtext-cont">
                    <div class="imgtext-img">
                        <img src="./floor.png" alt="">
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($category->id == 45)
        <section class="imgtext">
            <div class="container">
                <div class="imgtext-cont">
                    <div class="imgtext-img">
                        <img src="./skallatextlogo.png" alt="">
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="hits">
        <div class="container">
            @if($category->id != 45 && sizeof($category->attachment()->where('group', 'category_gallery')->get()))
                <section class="slitems">
                    <div class="title">Фотогалерея</div>
                    <div class="slitems-cont owl-carousel">
                        @foreach($category->attachment as $image)
                            @if($image->group == 'category_gallery')
                                <div class="slitems-item">
                                    <div class="slitems-item_img"
                                         style="background-image: url('{{$image->relativeUrl}}');">
                                        <img src=".{{$image->relativeUrl}}" alt="">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </section>
            @endif

            @if(!empty($subcategories->all()))
                <div class="info-cont_categories">
                    <div class="hits-line hits-line2">
                        <div class="title">Категории</div>
                    </div>
                    <div class="">
                        <div class="row hits-items">
                            @foreach($subcategories as $c)
                                <div class="col-md-3 hits-categories">
                                    <div class="hits-categories_item">
                                        <a href="{{$c->alias}}">
                                            <div class="hits-categories_item_cont">
                                                @foreach($c->attachment as $image)
                                                    @if($image->group == 'category_photo')
                                                        <div class="hits-categories_item__bg"></div>
                                                        <div class="hits-categories_item__img"
                                                             style="background-image: url('{{$image->relativeUrl}}');">
                                                            <img style="display:none;" src="{{$image->relativeUrl}}"
                                                                 alt="">
                                                        </div>
                                                        <div
                                                            class="hits-categories_item__title">{{$c->title}}</div>
                                                        <div class="hits-categories_item__icon">
                                                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </a>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if(!empty($category_children_products->all()))
                <div class="info-cont1">
                    <div class="hits-line hits-line2">
                        <h1 class="title">{{$category->title}}</h1>
                    </div>
                    <div class="row hits-items">
                        @foreach($category_children_products as $product)
                            <div class="col-6 col-md-3 hits-items_item2 data-id" data-id="{{$product->id}}">
                                <div class="hits-items_item2_cont">
                                    <a href="{{$category->alias}}/{{$product->alias}}">
                                        <div class="hits-items_item__slider hits-items_item__slider_t">
                                            @foreach($product->attachment as $image)
                                                @if($image->group == 'product_photo')
                                                    <div class="hits-items_item__slider__img
                                                        @if($product->category->id === 22) hits-items_item__slider__img--contain @endif"
                                                         style="background-image: url('{{$image->relativeUrl}}');@if($product->category->id === 23) background-size: contain; @endif">
                                                        <img src="{{$image->relativeUrl}}" alt="">
                                                        @foreach($product->attachment as $image)
                                                            @if($image->group == 'product_gallery')
                                                                <div class="hits-items_item__slider__img2"
                                                                     style="background-image: url('{{$image->relativeUrl}}');">
                                                                    <img src="{{$image->relativeUrl}}" alt="">
                                                                </div>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="hits-items_item__bot">
                                            <a href="{{$product->category->alias}}/{{$product->alias}}"
                                               class="hits-items_item__title">{{$product->title}}</a>
                                            <div class="hits-items_item__subtitle">
                                                <p>Артикул: {{$product->id}}</p>
                                                @if($product->brend)
                                                    <p>Бренд: {{$product->brend}}</p>
                                                @endif
                                                @if($product->collection)
                                                    <p>Коллекция {{$product->collection}}</p>
                                                @endif
                                            </div>
                                            <div class="hits-items_item__price">
                                                @if(!$product->show_price)
                                                    <span class="calculator-addcart add_cart">
                                                        <span>в корзину</span>
                                                        <img src="../img/icons/busked.png" alt="">
                                                    </span>
                                                    <div class="hits-items_item__subtitle">
                                                        <span>{{$product->price}} ₽ {{'/' . $product->measurement ?? ''}}</span>
                                                        @if($product->old_price)
                                                            <p><s>{{$product->old_price}} ₽</s></p>
                                                        @endif
                                                    </div>
                                                @else
                                                    <a style="margin: 0 auto;height: 40px; width: 160px; font-size: 16px;"
                                                       href="{{$product->category->alias}}/{{$product->alias}}"
                                                       class="calculator-addcart calculator-category">рассчитать</a>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        @if(!$napolnye_pokrytiia_get)
                            <div class="col-md-3 hits-items_item2">
                                <div class="hits-items_item2_cont">
                                    <a href="#" class="open-modal" data-modal="mymodal3">
                                        <div class="hits-items_item__slider hits-items_item__slider_t">
                                            <div class="hits-items_item__slider__img"
                                                 style="background-image: url('/storage/products/2023/02/18/a434309c5b821850aa9dac3b30c51d2a06eafbc8.webp');">
                                                <img
                                                    src="/storage/products/2023/02/18/a434309c5b821850aa9dac3b30c51d2a06eafbc8.webp"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="hits-items_item__bot">

                                            <div class="hits-items_item__title">Не нашли нужного варианта? Отправьте
                                                запрос
                                                на изготовление по индивидуальным размерам.
                                            </div>
                                        </div>
                                    </a>
                                    <a href="" class="calculator-addcart calculator-category open-modal"
                                       data-modal="mymodal3" style="width: 160px;">запрос менеджеру</a>
                                </div>
                            </div>
                        @endif

                    </div>
                    {{ $category_children_products->links() }}
                </div>
            @endif

            <section class="formBgImage">
                <div class="formBgImage-cont">
                    <div class="formBgImage-form">
                        <form action="">
                            <div class="formBgImage-form_title">Не смогли подобрать? <br> <span>МЫ ВАМ ПОМОЖЕМ!</span>
                            </div>
                            <div class="formBgImage-form_inputs">
                                <div class="formBgImage-form_input">
                                    <label class="squareShadowLabel"><span>Имя</span>
                                        <input class="squareShadow" type="text" name="name" placeholder="Введите имя"/>
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

            @if(empty($napolnye_pokrytiia_get))
                <section style="margin-top: 50px;" class="info">
                    <div class="container">
                        <div class="title">Этапы сделки</div>
                        <div class="info-cont">
                            <div class="info-items info-items2">
                                <div class="info-items_item info-items_item_stages active">
                                    <div class="info-items_item__img"
                                         style="background-image: url('../img/icons/weewe222.png');"><img
                                            src="../img/icons/weewe222.png" alt=""></div>
                                    <div class="info-items_item__title">Просчет</div>
                                    <div class="info-items_item__text__stages"> После оставленной Вами заявки или звонка
                                        менеджеру,
                                        Вам делается точный расчет стоимости нашими специалистами, которые консультируют
                                        по
                                        всем
                                        интересующим Вас вопросам, дают рекомендации и обсуждают детали по заявке. После
                                        чего Вам
                                        отправляется коммерческое предложение.
                                    </div>
                                </div>
                                <div class="info-items_item info-items_item_stages">
                                    <div class="info-items_item__img"
                                         style="background-image: url('../img/icons/icon111z.png');"><img
                                            src="../img/icons/icon111z.png" alt=""></div>
                                    <div class="info-items_item__title">Замер</div>
                                    <div class="info-items_item__text__stages">Выезд замерщика на объект осуществляется
                                        с
                                        согласием
                                        клиента, после предоставления адреса объекта и контактной информации. При себе у
                                        специалиста
                                        имеется фирменный кейс с образцами стекла и часто используемой фурнитурой. Замер
                                        осуществляется специалистом с большим опытом работы высокоточными приборами.
                                    </div>
                                </div>
                                <div class="info-items_item info-items_item_stages">
                                    <div class="info-items_item__img"
                                         style="background-image: url('../img/icons/icon111z1.png');"><img
                                            src="../img/icons/icon111z1.png" alt=""></div>
                                    <div class="info-items_item__title">Заказ</div>
                                    <div class="info-items_item__text__stages">Когда менеджеру приходит информация по
                                        замеру,
                                        делается окончательный расчет стоимости и дорабатываются детали, при
                                        необходимости
                                        согласовывается замена фурнитура и/или свет изделия. Вам предоставляется
                                        необходимая
                                        для Вас
                                        информация по спецификации (фото). После чего формируется счет и отправляется
                                        Вам.
                                    </div>
                                </div>
                                <div class="info-items_item info-items_item_stages">
                                    <div class="info-items_item__img"
                                         style="background-image: url('../img/icons/icon111.png');"><img
                                            src="../img/icons/icon111.png" alt=""></div>
                                    <div class="info-items_item__title">Оплата</div>
                                    <div class="info-items_item__text__stages">Оплачиваете счет удобным для Вас
                                        способом:
                                        QR-код, по
                                        реквизитам компании, переводом на карту или наличными в салоне. Предоплата
                                        50%-70%
                                        для
                                        запуска заказа в производство. Оплата предусматривает собой выставление счета на
                                        оплату
                                        товара и услуг в котором находится вся спецификация товара и данные для оплаты,
                                        а
                                        так-же
                                        памятка покупателя. К счету прилагается договор, в котором также есть условия
                                        эксплуатации
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
                                        менеджер для подтверждения готовности принять товар. Если нет необходимости его
                                        хранения на
                                        нашем складе, информация передаётся в службу доставки. Дату и время доставки
                                        согласовываете
                                        непосредственно с экспедитором. По прибытию товара оставляете заявку на монтаж.
                                    </div>
                                </div>
                                <div class="info-items_item info-items_item_stages">
                                    <div class="info-items_item__img"
                                         style="background-image: url('../img/icons/icon10.png');"><img
                                            src="../img/icons/icon10.png" alt=""></div>
                                    <div class="info-items_item__title">Монтаж</div>
                                    <div class="info-items_item__text__stages">Наша компания имеет свой собственный
                                        сервисный центр,
                                        в который входят только самые квалифицированные мастера с большим опытом работы.
                                        Мы
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
            @endif


            @if($category->id == 18)
                <div class="kviz">
                    <div data-marquiz-id="643aa27aaf4733002510de4c"></div>
                    <script>(function (t, p) {
                            window.Marquiz ? Marquiz.add([t, p]) : document.addEventListener('marquizLoaded', function () {
                                Marquiz.add([t, p])
                            })
                        })('Inline', {
                            id: '643aa27aaf4733002510de4c',
                            height: '530',
                            buttonText: 'Пройти тест',
                            bgColor: '#2cbf00',
                            textColor: '#ffffff',
                            rounded: true,
                            shadow: 'rgba(44, 191, 0, 0.5)',
                            blicked: true,
                            buttonOnMobile: true
                        })</script>

                    <div data-marquiz-id="65736b67b33ff10025b6c7bf"></div>
                    <script>(function (t, p) {
                            window.Marquiz ? Marquiz.add([t, p]) : document.addEventListener('marquizLoaded', function () {
                                Marquiz.add([t, p])
                            })
                        })('Button', {
                            id: '65736b67b33ff10025b6c7bf',
                            buttonText: 'Калькулятор расчета стоимости',
                            bgColor: '#fd9c04',
                            textColor: '#ffffff',
                            rounded: true,
                            shadow: 'rgba(253, 156, 4, 0.5)',
                            blicked: true,
                            fixed: 'right'
                        })</script>
                </div>
            @endif

            <section class="stati" style="margin-top: 10px;">
                <div class="row cart-blueprints">
                    <div class="col-md-6">
                        @foreach($category->attachment as $image)
                            @if($image->group == 'blueprints_gallery')
                                <img src="{{$image->relativeUrl}}" alt="">
                            @endif
                        @endforeach
                    </div>
                    <div class="col-md-6 cart-blueprints_right more">{!! $category->blueprints_text !!} <span
                            class="more_open">еще...</span></div>
                </div>
            </section>
            @if($stati)
                <section class="stati" style="margin-top: 50px;">
                    <div class="title">Статьи</div>
                    <div class="stati-cont">
                        <div class="row">
                            @foreach($stati as $item)
                                <div class="col-md-3 col-sm-4 col-6">
                                    <div class="stati-item">
                                        <div class="stati-item_img">
                                            <a href="{{"/stati/" . $item->alias}}">
                                                <div class="stati-item_img__cont"
                                                     style="background-image: url('{{$item->attachment[0]->relativeUrl ?? 'no_image.jpg'}}');">
                                                </div>
                                            </a>
                                        </div>
                                        <div class="stati-item_title">
                                            <a href="{{"/stati/" . $item->alias}}">{{$item->title}}</a>
                                        </div>
                                        <div class="stati-item_text">{{$item->subtitle}}</div>
                                        <span>{{date('d-m-Y', strtotime($item->updated_at))}}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif


            <section class="stati" style="margin-top: 10px;">
                @if($category->id != 45)
                    <div class="title">Описание</div>
                @endif

                <div class="stati-cont">
                    {!! $category->description !!}
                </div>
            </section>

        </div>
    </section>

@endsection

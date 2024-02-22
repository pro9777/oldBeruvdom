<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Marquiz script start -->
    <script>
        (function (w, d, s, o) {
            var j = d.createElement(s);
            j.async = true;
            j.src = '//script.marquiz.ru/v2.js';
            j.onload = function () {
                if (document.readyState !== 'loading') Marquiz.init(o);
                else document.addEventListener("DOMContentLoaded", function () {
                    Marquiz.init(o);
                });
            };
            d.head.insertBefore(j, d.head.firstElementChild);
        })(window, document, 'script', {
                host: '//quiz.marquiz.ru',
                region: 'eu',
                id: '643acb88af4733002510e1bd',
                autoOpen: false,
                autoOpenFreq: 'once',
                openOnExit: true,
                disableOnMobile: false
            }
        );
    </script>
    <!-- Marquiz script end -->

    <base href="{{URL::to('/')}}"/>
    <title>@yield('page-title')</title>
    <meta charset="utf-8"/>
    <meta name="description" content="@yield('description')"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
    <meta name="keywords" content="@yield( 'keywords')"/>

    <link rel="icon" type="image/png" href="../img/favicon/logo1.jpg"/>
    <!-- Inlude css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    {{--    <link rel="stylesheet" href="libs/fontawesome/font-awesome.css"/>--}}
    <link rel="stylesheet" href="./libs/fontawesome6/css/fontawesome.css"/>
    <link rel="stylesheet" href="./libs/fontawesome6/css/all.min.css"/>
    <link rel="stylesheet" href="libs/owlcarousel/assets/owl.carousel.min.css"/>
    <link rel="stylesheet" href="libs/owlcarousel/assets/owl.theme.default.min.css"/>
    <link type="text/css" rel="stylesheet" href="libs/lightGallery-master/dist/css/lightgallery.css"/>
    <link rel="stylesheet" href="css/main.css?_v=23"/>
    <meta name="yandex-verification" content="5c04450ae8f41152"/>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (m, e, t, r, i, k, a) {
            m[i] = m[i] || function () {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            for (var j = 0; j < document.scripts.length; j++) {
                if (document.scripts[j].src === r) {
                    return;
                }
            }
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(87516133, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/87516133" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->

</head>

<body>

<div class="wrapper">
    <!--header-->
    @include('home.header')
    <!--header end-->
    <!--content-->
    <div class="content">
        @yield('content')
    </div>
    <!--content end-->

    <!--footer-->
    <footer class="footer">
        <div class="container">
            <div class="footer-cont">
                <div class="row">
                    <div class="col-md-3">
                        <div class="footer-logo">
                            <a href="/"><img src="../img/bot_logo.png" alt=""></a>
                            <div class="footer-logo_bot">
                                <div class="footer-logo_bot__icon">
                                    <a href="https://wa.me/74950230515" target="_blank">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>

                                </div>
                                <div class="footer-logo_bot__icon" style=" margin-top: 2px; ">
                                    <a href="https://t.me/beru_v_dom" target="_blank">
                                        <i class="fa-regular fa-paper-plane"></i>
                                    </a>

                                </div>
                                <div class="footer-logo_bot__icon">
                                    <a href="https://dzen.ru/id/60bddc55516ff711d42d77be?hide_interest_header=1&utm_referer=beruvdom.ru"
                                       target="_blank">
                                        <img src="../img/svg/icons8-yandex-zen-32bot.png" alt="">
                                    </a>
                                </div>
                                <div class="footer-logo_bot__icon" style=" margin-top: 2px; ">
                                    <a href="https://instagram.com/beruvdom?igshid=YmMyMTA2M2Y=" target="_blank">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>

                                </div>
                            </div>
                            <div class="footer-logo_botp">
                                <div class="footer-logo_botp__icon">
                                    <a href="#"><img src="../img/icons/p1.png" alt=""></a>
                                </div>
                                <div class="footer-logo_botp__icon">
                                    <a href="#"><img src="../img/icons/p2.png" alt=""></a>
                                </div>
                                <div class="footer-logo_botp__icon">
                                    <a href="#"><img src="../img/icons/p3.png" alt=""></a>
                                </div>
                            </div>

                        </div>
                        <p class="footer-rec">
                            ООО "ДВЕРИ И ПОЛЫ"<br>
                            ИНН: 7743211100<br>
                            КПП: 772401001<br>
                            ОГРН: 1177746524670<br>
                            ОКПО: 15799049<br>
                            Юридический адрес: 115201, Москва г, Котляковский 1-Й пер, дом № 3, Эт<br>
                            Антресоль 3 Пом VIII Ком 3А</p>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-6 col-md-3 col-sm-6">
                                <div class="footer-title">Информация</div>
                                <ul>
                                    <li><a href="{{url("/page/o-magazine")}}">О магазине</a></li>
                                    <li><a href="{{url("/stati/")}}">Статьи</a></li>
                                    <li><a href="{{url("/page/dostavka")}}">Доставка</a></li>
                                    <li><a href="{{url("/page/montaz")}}">Монтаж</a></li>
                                    <li><a href="{{url("/page/oplata")}}">Оплата</a></li>
                                    <li><a href="#">Вакансии</a></li>
                                    <li><a href="https://yandex.ru/maps/-/CCUauUhSgD" target="_blank">Отзывы</a></li>
                                </ul>
                            </div>
                            <div class="col-6 col-md-3 col-sm-6">
                                <div class="footer-title">Категории</div>
                                <ul>
                                    @foreach($categoryes as $category)
                                        <li>
                                            <a href="{{route('category', ['category' => $category->alias])}}">{{$category->title}}</a>
                                        </li>
                                    @endforeach
{{--                                    <li><a href="#">Межкомнатные перегородки (скоро)</a></li>--}}
{{--                                    <li><a href="#">Напольные покрытия (скоро)</a></li>--}}
                                </ul>
                            </div>
                            <div class="col-6 col-md-3 col-sm-6">
                                <div class="footer-title">Время работы</div>
                                <ul>
                                    <li>Магазин: без выходных с 10:00 до 20:00</li>
                                    <li>Конструкторское бюро: будни, с 10:00 до 18:00</li>
                                    <li>Склад: будни, с 10:00 до 18:00</li>
                                </ul>
                            </div>
                            <div class="col-6 col-md-3 col-sm-6">
                                <div class="footer-title">Наши контакты</div>

                                <ul>
                                    <li>
                                        <a href="tel:+7 (495) 023-05-15" onclick="ym(87516133,'reachGoal','click on the phone number'); return true;">+7 (495) 023-05-15</a><br>
                                        <a href="mailto:info@beruvdom.ru">info@beruvdom.ru</a>
                                    </li>

                                    <li>
                                        <p class="footer-title">Салон:</p>
                                        <a style="display:block;" target="_blank"
                                           href="https://yandex.ru/maps/213/moscow/?ll=37.481170%2C55.843574&mode=search&poi%5Bpoint%5D=37.480102%2C55.843157&poi%5Buri%5D=ymapsbm1%3A%2F%2Forg%3Foid%3D237980524462&sctx=ZAAAAAgCEAAaKAoSCdMyUu%2BpiEJAEUm6ZvLNEExAEhIJt3pOet%2F4ij8RigYpeAq5cj8iBgABAgMEBSgKOABAnZIHSAFqAnJ1nQHNzEw9oAEAqAEAvQEpS%2F3iwgEStpD0woQHycfvxMEE%2FILW5owE6gEA8gEA%2BAEAggKiAdCY0L3RgtC10YDRjNC10YAg0YbQtdC90YLRgCDCq9CS0L7QtNC90YvQucK7INCb0LXQvdC40L3Qs9GA0LDQtNGB0LrQvtC1INGI0L7RgdGB0LUgNTjRgSA3LCDRhtC%2B0LrQvtC70YzQvdGL0Lkg0Y3RgtCw0LYg0KHQsNC70L7QvTog0YHQtdC60YbQuNGPIDAxMS0wMTMsINCzLtCc0L7RgYoCAJICAzIxM5oCDGRlc2t0b3AtbWFwcw%3D%3D&sll=37.481170%2C55.843574&sspn=0.008335%2C0.002914&text=%D0%98%D0%BD%D1%82%D0%B5%D1%80%D1%8C%D0%B5%D1%80%20%D1%86%D0%B5%D0%BD%D1%82%D1%80%20%C2%AB%D0%92%D0%BE%D0%B4%D0%BD%D1%8B%D0%B9%C2%BB%20%D0%9B%D0%B5%D0%BD%D0%B8%D0%BD%D0%B3%D1%80%D0%B0%D0%B4%D1%81%D0%BA%D0%BE%D0%B5%20%D1%88%D0%BE%D1%81%D1%81%D0%B5%2058%D1%81%207%2C%20%D1%86%D0%BE%D0%BA%D0%BE%D0%BB%D1%8C%D0%BD%D1%8B%D0%B9%20%D1%8D%D1%82%D0%B0%D0%B6%20%D0%A1%D0%B0%D0%BB%D0%BE%D0%BD%3A%20%D1%81%D0%B5%D0%BA%D1%86%D0%B8%D1%8F%20011-013%2C%20%D0%B3.%D0%9C%D0%BE%D1%81&z=17.62">Интерьер
                                            центр «Водный» Ленинградское шоссе 58с 7, цокольный этаж
                                            Салон: секция 011-013,
                                            г.Москва</a>
                                    </li>
                                    <li>
                                        <p class="footer-title">Главный офис:</p>
                                        <a style="display:block;" target="_blank"
                                           href="https://yandex.ru/maps/213/moscow/house/1_y_kotlyakovskiy_pereulok_3/Z04YcARoTkQOQFtvfXp1eHRiYQ==/?ll=37.638718%2C55.649815&z=16.96">115201.
                                            Москва
                                            ул. 1-й Котляковский переулок
                                            дом 3, офис 49</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <form action="" class="footer-form">
                            <div class="footer-title">Остались вопросы</div>
                            <div class="row footer-form">
                                <div class="col-md-3 col-sm-6">
                                    <input type="text" name="name" placeholder="Ваше имя">
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <input type="text" name="number" placeholder="Номер телефона">
                                </div>
                                <div style="display: none" class="formBgImage-form_checkbox">
                                    <label class="checkboxSmallLabel">
                                        <input class="checkboxSmall" type="checkbox" name="consent" checked=""><span>Я согласен на обработку моих персоональных данных</span>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <button>Отправить</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <div class="rights">
            <p>© 2004, ООО «Двери и Полы». Все права защищены</p>


            <p style="margin-top: 10px">Сайт носит исключительно информационный характер и никакая информация,
                опубликованная на нём, ни при каких условиях не является публичной офертой</p>
        </div>
    </footer>
    <!--footer end-->
</div>


@if($route != 'cart')
    <div class="basket_abs" data-bs-toggle="modal" data-bs-target="#modal">
        <img src="../img/basked.png" alt="">
        <span class="basket-quantity">
        {{isset($iser_id) ? \Cart::session($iser_id)->getTotalQuantity() : 0}}
    </span>
    </div>

    <!-- modals -->

    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <section class="basked basked-modal">
                    <div class="basked-cont">
                        <div class="basked-left">
                            <div class="basked-title">
                                <div class="title">Корзина</div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            {{--                            <div class="basked-line"></div>--}}
                            <div class="basked-left_items"></div>
                        </div>

                    </div>
                    <a href="{{route('cart')}}"
                       class="basked-addcart calculator-addcart calculator-addcart2">Оформить</a>
                </section>
            </div>
        </div>
    </div>
@endif

<div class="mymodal mymodal4 mymodal3">
    <div class="mymodal-cont" style="padding: 25px">
        <div class="mymodal-close"><i class="fa fa-times" aria-hidden="true"></i></div>
        <div class="mymodal-content">
            <form action="" class="form form-bye " style="text-align:center;">
                <div class="cart-title">ЗАПРОС МЕНЕДЖЕРУ</div>
                <div class="basked-left_form basked-left_form2">
                    <label class="basked-left_form__lavel">
                        <span>Имя</span>
                        <input class="input" name="name" type="text" placeholder="Введите имя" value="">
                    </label>
                    <label class="basked-left_form__lavel">
                        <span>Номер</span>
                        <input class="input" name="number" type="number" placeholder="Номер телефона" value="">
                    </label>
                    <div class="formBgImage-form_checkbox">
                        <label class="checkboxSmallLabel">
                            <input class="checkboxSmall" type="checkbox" name="consent" checked=""><span>Я согласен на обработку моих персоональных данных</span>
                        </label>
                    </div>
                    <input value="Отправить" name="sendMail" type="submit" class="button">
                </div>
                <div class="privacy-policy">Нажимая на кнопку, вы соглашаетесь с</br>
                    <a href="{{url("/page/politika-konfidencialnosti")}}"> политикой конфиденциальности</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modals -->

<!-- js files -->
<div class="blackout"></div>
<div id="showgenerator" class="open-modal" data-modal="mymodal4">ЗАПРОС МЕНЕДЖЕРУ</div>

<script src="https://unpkg.com/imask"></script>
<script src="libs/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="libs/owlcarousel/owl.carousel.min.js"></script>
<script src="libs/lightGallery-master/dist/js/lightgallery-all.min.js"></script>
<script src="/js/typeahead.bundle.js"></script>
<script src="./js/common.js?_v=22"></script>
<script src="./js/main.js?_v=22"></script>
@yield('custom_js')
<script>
    $(document).ready(function () {
        $('.mymodal4 .button').on('click', function (e) {
            e.preventDefault();
            sendEmail('.mymodal4 .form', 'ЗАПРОС МЕНЕДЖЕРУ');
        })

        $('.btnCircle').on('click', function (e) {
            e.preventDefault();
            sendEmail('.formBgImage form', 'Получить консультацию');
        })

        $('.footer-form button').on('click', function (e) {
            e.preventDefault();
            sendEmail('.footer-form', 'ЗАПРОС C ФУТЕРА');
        })

        function sendEmail(block = '', from = '') {
            let name = $(`${block} input[name='name']`).val();
            let number = $(`${block} input[name='number']`).val();
            let consent = document.querySelector(`${block} input[name='consent']`);
            if(consent && consent.checked) {
                consent = 1;
            }else{
                consent = null;
            }
            $.ajax({
                url: '{{route('sendEmail')}}',
                type: 'POST',
                data: {
                    'from': from,
                    'name': name,
                    'number': number,
                    'consent': consent,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    $('.mymodal4 input').removeClass('error').addClass('success');
                    if ($.isEmptyObject(data.error)) {
                        chips('Запрос успешно отправлен', 5000);
                        jQuery(`${block}`)[0].reset();
                        setTimeout(function () {
                            $('.mymodal4').removeClass('mymodal--active');
                        }, 2000);
                        if (block == '.mymodal4 .form') {
                            ym(87516133, 'reachGoal', 'Request to the manager')
                        }
                        if (block == '.footer-form') {
                            ym(87516133, 'reachGoal', 'footer')
                        }
                        if (block == '.formBgImage form') {
                            ym(87516133,'reachGoal','Get advice')
                        }

                        window.location.href = "{{route('success')}}";
                    } else {
                        $.each(data.error, function (key, value) {
                            setTimeout(function () {
                                $(`${block} input[name=` + key + `]`).addClass('error').removeClass('success');
                            }, 150);
                        })
                        chips('Заполните обязательные поля', 'chips--red', 5000);
                    }
                }
            })
        }

        /*SEARCH*/
        if ($('*').is('#typeahead')) {

            var products = new Bloodhound({
                remote: {
                    // url: PATH + '/search/typeahead?query=%QUERY',
                    url: '{{route('search')}}?query=%QUERY',
                    wildcard: '%QUERY'
                },
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace
            });

            products.initialize();

            $("#typeahead").typeahead({
                highlight: true,
            }, {
                limit: 10,
                source: products.ttAdapter(),

                // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
                name: 'usersList',

                // the key from the array we want to display (name,id,email,etc...)
                templates: {
                    empty: [
                        '<div class="list-group search-results-dropdown"><div class="list-group-item">Ничего не найдено.</div></div>'
                    ],
                    header: [
                        '<div class="list-group search-results-dropdown">'
                    ],
                    suggestion: function (data) {
                        return '<div class="tt-suggestion tt-selectable">' + data.id + ' - ' + data.title + '</div>'
                    }
                }
            });

            $('#typeahead').bind('typeahead:select', function (ev, suggestion) {
                window.location = '{{route('search')}}/?s=' + encodeURIComponent(suggestion.title);
            });

        }
        /*SEARCH*/


        validateInput(0);
        // price_change();


        $('.add_to_cart').click(function () {
            var this_el = $(this);

            validateInput().done(function (data) {
                if (data.success) {
                    addToCart(this_el);

                    getCartQty();
                } else {
                    chips('Выберите обязательные поля', 'chips--red', 5000);
                }
            });
        })

        $('.add_cart').click(function () {
            addToCart($(this));
            getCartQty();
        })

        //удаление товара с корзины
        $('body').on('click', '.delete_cart', function (e) {
            removeCart($(this));
            getCartQty();
        })

        //обновить содержимое при нажатии на корзину
        $('.basket_abs').on('click', function () {
            getCart()
        })

        //получить количство товаров
        function getCartQty() {
            setTimeout(function () {
                $.ajax({
                    url: '{{route('getCartQty')}}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (data) => {
                        $('.basket-quantity').text(data);
                    }
                })
            }, 100);
        }


        //добавить товар в корзину
        function addToCart(element) {
            var id = '';
            if ($('.cart-title').length > 0) {
                id = $('.cart-title').data('id');
            }
            if ($('.data-id').length > 0) {
                id = element.closest('.data-id').attr('data-id');
                console.log(id);
            }
            var qty = 1;

            if ($('.quantity_product').length > 0) {
                qty = parseInt($('.quantity_product').val());
            }


            $.ajax({
                url: '{{route('addToCart')}}',
                type: 'POST',
                data: {
                    'id': id,
                    'qty': qty,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    ym(87516133, 'reachGoal', 'Adding to cart')
                    chips('Добавлен в корзину', 5000);
                }
            })
        }

        //удалить товар с корзины
        function removeCart($this) {
            let id = $this.attr('data-id');
            $.ajax({
                url: '{{route('deleteToCart')}}',
                type: 'POST',
                data: {
                    'id': id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    if (res) {
                        $('.basked-left_items').html(res);
                    } else {
                        $('.basked-left_items').html(res);
                        $('.modal').modal('hide')
                    }

                }
            })
        }

        //обновить количество в корзине
        function getCart() {
            $.ajax({
                url: '{{route('getCart')}}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    $('.basked-left_items').html(res);
                }
            })
        }


        //изменении цены калькулятора
        $('body').on('click', '.minus', function () {
            var input = $(this).parent().find('input');
            var modal = input.attr('data-m');
            var count = parseInt(input.val()) - 1;
            count = count < 1 ? 1 : count;
            input.val(count);
            input.change();
            if (modal == 'modal') {
                let id = $(this).parent().attr('data-id');
                let qty = input.val();
                updateCart(id, qty, $(this))
                getCartQty();
            }
            price_change()
            return false;
        });
        $('body').on('click', '.plus', function () {
            var input = $(this).parent().find('input');
            var modal = input.attr('data-m');
            input.val(parseInt(input.val()) + 1);
            input.change();
            if (modal == 'modal') {
                let id = $(this).parent().attr('data-id');
                let qty = input.val();
                updateCart(id, qty, $(this))

                getCartQty();
                return false;
            }
            price_change()
        });

        $('body').on('input', '.quantity_product', function () {
            var input = $(this).parent().find('input');
            var modal = input.attr('data-m');
            if (modal == 'modal') {
                let id = $(this).parent().attr('data-id');
                let qty = input.val();
                updateCart(id, qty, $(this))
                getCartQty();
                return false;
            }
            price_change()
        });


        //обновление товаров в корзине
        function updateCart(id, qty, this_) {

            $.ajax({
                url: '{{route('updateToCart')}}',
                type: 'POST',
                data: {
                    'id': id,
                    'qty': qty,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    this_.closest('.basked-left_item').find('.basked-left_item__price span').text(data.price)
                    $('.basked-total').text(data.total);
                    $('.basked-qty').text(data.qty);
                }
            })
        }

        //перерасчет калькулятора
        function price_change() {
            let id = $('.cart-title').data('id');
            let total_qty = parseInt($('.quantity_product').val());

            var values = [];
            $(".calculator-top :input").each(function (index, item) {
                let id = $(this).attr('data-id');
                let name = $(this).attr('data-name');
                let value = $(this).val();
                if ($(item).is(':checked')) {
                    values.push({
                        'id': id,
                        'name': name,
                        'value': '',
                    });
                }
                if ($(this).attr('type') == 'number' && value != '') {
                    values.push({
                        'id': id,
                        'name': name,
                        'value': value,
                    });
                }

            });

            $.ajax({
                url: '{{route('priceCalculation')}}',
                type: 'POST',
                data: {
                    id: id,
                    qty: total_qty,
                    ids_values: values
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    $('.calculator-totalprice span').text(data.total_price);
                    let metersSquared = document.querySelector('.metersSquared');
                    let numberOfPackages = document.querySelector('.numberOfPackages');
                    if(data.metersSquared && metersSquared){
                        let calculator_bot_head = document.querySelector('.calculator-bot_head');
                        calculator_bot_head.classList.remove('d-none')
                        metersSquared.textContent = `${data.metersSquared}  м2`
                        numberOfPackages.textContent = `${data.numberOfPackages}  упак.`
                    }
                }
            })
        }

        $('.calculator').on('input', function () {
            validateInput()
            price_change()
        });


        function validateInput(status = 1) {
            //проходимся по всем блокам калькулятора
            let r_inputs = [];
            $(".calculator-top .control").each(function (index, item) {
                let req = $(this).attr('data-r');
                let name = $(this).attr('data-name');
                let value = $(this).find('input').val();

                //проверям обязательность поля
                if (req == 1) {
                    //если поля radio выбираем выбранный
                    if ($(this).find('input').attr('type') == 'radio') {
                        let input_checked_val = $(this).find('input:checked').val();
                        r_inputs.push({
                            'name': name,
                            'value': input_checked_val,
                        });
                    } else {
                        r_inputs.push({
                            'name': name,
                            'value': value,
                        });
                    }
                }
            })

            let data = [];
            $(".calculator-top input").each(function (index, item) {

                let title = $(this).attr('data-title');
                let name = $(this).attr('data-name');
                let value = $(this).val();
                if ($(item).is(':checked')) {
                    data.push({
                        'title': title,
                        'name': name,
                        'value': value,
                    });
                }
                if ($(this).attr('type') == 'number' && value != '') {
                    data.push({
                        'title': title,
                        'name': name,
                        'value': value,
                    });
                }
            })
            return $.ajax({
                url: '{{route('validateInput')}}',
                type: 'POST',
                data: {
                    'req': r_inputs,
                    'data': data,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    $('.calculator-top input').parent().removeClass('error').addClass('success');

                    if ($.isEmptyObject(data.error)) {
                    } else {
                        var data_name = '';
                        $.each(data.error, function (key, value) {
                            data_name = key;
                            return false;
                        })
                        if (status != 0) {
                            $('html').animate({
                                    scrollTop: $('.control[data-name="' + data_name + '"]').offset().top - 250
                                }, 50 // скорость прокрутки
                            );

                        }

                        $.each(data.error, function (key, value) {


                            // console.log(key);
                            setTimeout(function () {
                                $('input[name=' + key + ']').parent().addClass('error').removeClass('success');
                            }, 150);
                        })

                    }
                }
            })
        }
    })
</script>
</body>
</html>

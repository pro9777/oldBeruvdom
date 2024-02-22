<header class="header default">
    <div class="container">
        <div class="header-cont">
            <div class="header-line">
                <div class="header-line_left">
                    <div class="header-logo">
                        <a href="/"><img src="../img/logo.png" alt=""></a>
                    </div>
                    <div class="header-line_left__title">Лучшие бренды в одном месте собери свой дизайн</div>
                    <div class="header-line_left__mob">
                        <spun class="header-line_left__mob__lines"></spun>
                    </div>
                </div>
                <div class="header-line_right">
                    <div class="header-line_right__info dn">
                        <span class="title">Ежедневно</span>
                        <span class="subtitle">с 10:00 до 20:00 </span>
                    </div>
                    <div class="header-line_right__info">
                        <a class="subtitle" href="mailto:info@beruvdom.ru">info@beruvdom.ru</a>
{{--                        <a class="subtitle" href="tel:+7 (495) 023-05-15" onclick="ym(87516133,'reachGoal','click on the phone number'); return true;">+7 (495) 023-05-15</a>--}}
                        <a class="subtitle" href="tel:+7 (495) 023-05-15" onclick="ym(87516133,'reachGoal','click on the phone number'); return true;">
                            <small style="display: flex; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit;">
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.923077;">+</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.923077;">7</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.846154;">(</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.769231;">4</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.692308;">9</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.615385;">5</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.538462;">)</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.461538;">0</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.384615;">2</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.307692;">3</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.230769;">0</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.153846;">5</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.0769231;">1</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0;">5</small></small>
                        </a>
                    </div>

                    {{--                    <div class="header-line_right__info">--}}
                    {{--                        <span class="title">Корзина</span>--}}
                    {{--                        <div class="basket" data-bs-target="#basket_modal">--}}
                    {{--                            <img src="../img/basked.png" alt="">--}}
                    {{--                            <span class="basket-quantity" data-bs-toggle="modal" data-bs-target="#modal">--}}
                    {{--                                {{isset($_COOKIE['cart_id']) ? \Cart::session($_COOKIE['cart_id'])->getTotalQuantity() : 0}}--}}
                    {{--                            </span>--}}
                    {{--                            <span class="subtitle">товаров</span>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                </div>
            </div>
            <div class="header-nav">
                <div class="header-nav_cont">
                    <div class="header-menu">
                        <ul>
                            <li>
                                <a href="#"><i class="fa-solid fa-bars"></i>Каталог <i class="fa fa-angle-down"></i></a>
                                <ul>
                                    @foreach($categoryes as $category)
                                        <li>
                                            <a href="{{route('category', ['category' => $category->alias])}}">
                                                @foreach($category->attachment as $image)
                                                    @if($image->group == 'category_photo')
                                                        <img src="{{$image->relativeUrl}}" alt="">{{$category->title}}
                                                    @endif
                                                @endforeach
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li>
                                <a href="{{url("/page/o-magazine")}}">О магазине</a>
                            </li>
                            <li>
                                <a href="{{url("/stati/")}}">Статьи</a>
                            </li>

                            <li>
                                <a href="{{url("/page/oplata")}}"></i>Оплата<i class="fa fa-angle-down"></i></a>
                                <ul>
                                    @foreach($page_header as $item)
                                       <li>
{{--                                           <a href="{{url("/page/zamer")}}">--}}
                                           <a href="{{route('page', ['name' => $item->alias])}}">
                                               <img
                                                    src="{{$item->attachment[0]->relativeUrl}}"
                                                    alt="">{{$item->title}}
                                           </a>
                                       </li>
                                    @endforeach

                                </ul>
                            </li>
                            <li>
                                <a href="https://yandex.ru/maps/org/beru_v_dom/237980524462/reviews/?ll=37.615855%2C55.728635&mode=search&sll=37.671139%2C55.642692&sspn=0.168915%2C0.062329&tab=reviews&text=%D0%B1%D0%B5%D1%80%D1%83%D0%B2%D0%B4%D0%BE%D0%BC&z=11"
                                   target="_blank">Отзывы</a>
                            </li>
                            <li>
                                <a href="{{url("/contacts")}}">Контакты</a>
                            </li>
                        </ul>
                        <div class="header-menu_cont">
                            <div class="header-menu_icons">
                                <span>Мы в социальных сетях:</span>
                                <div class="header-menu_icons__cont">

                                    <div class="header-nav_icon">
                                        <a href="https://wa.me/74950230515" target="_blank">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </a>
                                    </div>
                                    <div class="header-nav_icon">
                                        <a href="https://t.me/beru_v_dom" target="_blank">
                                            <i class="fa-regular fa-paper-plane"></i>
                                        </a>
                                    </div>

                                    <div class="header-nav_icon">
                                        <a href="https://dzen.ru/id/60bddc55516ff711d42d77be?hide_interest_header=1&utm_referer=beruvdom.ru"
                                           target="_blank">
                                            <img src="../img/svg/icons8-yandex-zen-32.png" alt="">
                                        </a>
                                    </div>

                                    <div class="header-nav_icon" style="margin-right: 10px;">
                                        <a href="https://instagram.com/beruvdom?igshid=YmMyMTA2M2Y=" target="_blank">
                                            <i style=" margin-top: 2px; " class="fa-brands fa-instagram"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="header-line_right__info header-line_right__info__menu">
                                <a class="subtitle" href="mailto:info@beruvdom.ru">info@beruvdom.ru</a>
                                <a class="subtitle" href="tel:+7 (495) 023-05-15" onclick="ym(87516133,'reachGoal','click on the phone number'); return true;">
                                    <small style="display: flex; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit;">
                                        <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.923077;">+</small>
                                        <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.923077;">7</small>
                                        <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.846154;">(</small>
                                        <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.769231;">4</small>
                                        <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.692308;">9</small>
                                        <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.615385;">5</small>
                                        <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.538462;">)</small>
                                        <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.461538;">0</small>
                                        <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.384615;">2</small>
                                        <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.307692;">3</small>
                                        <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.230769;">0</small>
                                        <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.153846;">5</small>
                                        <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.0769231;">1</small>
                                        <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0;">5</small></small>
                                </a>
                            </div>
                            <div class="header-menu_text">
                                <img src="../img/icons/map_acon.png" alt="">
                                <a style="display:block;" target="_blank"
                                   href="https://yandex.ru/maps/213/moscow/?ll=37.481170%2C55.843574&mode=search&poi%5Bpoint%5D=37.480102%2C55.843157&poi%5Buri%5D=ymapsbm1%3A%2F%2Forg%3Foid%3D237980524462&sctx=ZAAAAAgCEAAaKAoSCdMyUu%2BpiEJAEUm6ZvLNEExAEhIJt3pOet%2F4ij8RigYpeAq5cj8iBgABAgMEBSgKOABAnZIHSAFqAnJ1nQHNzEw9oAEAqAEAvQEpS%2F3iwgEStpD0woQHycfvxMEE%2FILW5owE6gEA8gEA%2BAEAggKiAdCY0L3RgtC10YDRjNC10YAg0YbQtdC90YLRgCDCq9CS0L7QtNC90YvQucK7INCb0LXQvdC40L3Qs9GA0LDQtNGB0LrQvtC1INGI0L7RgdGB0LUgNTjRgSA3LCDRhtC%2B0LrQvtC70YzQvdGL0Lkg0Y3RgtCw0LYg0KHQsNC70L7QvTog0YHQtdC60YbQuNGPIDAxMS0wMTMsINCzLtCc0L7RgYoCAJICAzIxM5oCDGRlc2t0b3AtbWFwcw%3D%3D&sll=37.481170%2C55.843574&sspn=0.008335%2C0.002914&text=%D0%98%D0%BD%D1%82%D0%B5%D1%80%D1%8C%D0%B5%D1%80%20%D1%86%D0%B5%D0%BD%D1%82%D1%80%20%C2%AB%D0%92%D0%BE%D0%B4%D0%BD%D1%8B%D0%B9%C2%BB%20%D0%9B%D0%B5%D0%BD%D0%B8%D0%BD%D0%B3%D1%80%D0%B0%D0%B4%D1%81%D0%BA%D0%BE%D0%B5%20%D1%88%D0%BE%D1%81%D1%81%D0%B5%2058%D1%81%207%2C%20%D1%86%D0%BE%D0%BA%D0%BE%D0%BB%D1%8C%D0%BD%D1%8B%D0%B9%20%D1%8D%D1%82%D0%B0%D0%B6%20%D0%A1%D0%B0%D0%BB%D0%BE%D0%BD%3A%20%D1%81%D0%B5%D0%BA%D1%86%D0%B8%D1%8F%20011-013%2C%20%D0%B3.%D0%9C%D0%BE%D1%81&z=17.62">Ленинградское
                                    шоссе 58с 7, цокольный этаж
                                    секция 011-013, г.Москва</a>
                                <p></p>
                            </div>
                            <div class="header-menu_bot">
                                <div class="button button--blue open-modal" data-modal="mymodal4">Отправить заявку</div>
                                <a href="tel:+7 (495) 023-05-15" onclick="ym(87516133,'reachGoal','click on the phone number'); return true;" class="tel"></a>
                            </div>
                        </div>

                    </div>

                    <div class="header-nav_icons">
                        <div class="header-nav_icon">
                            <a href="https://wa.me/74950230515" target="_blank">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                        </div>
                        <div class="header-nav_icon">
                            <a href="https://t.me/beru_v_dom" target="_blank">
                                <i class="fa-regular fa-paper-plane"></i>
                            </a>
                        </div>

                        <div class="header-nav_icon">
                            <a href="https://dzen.ru/id/60bddc55516ff711d42d77be?hide_interest_header=1&utm_referer=beruvdom.ru"
                               target="_blank">
                                <img src="../img/svg/icons8-yandex-zen-32.png" alt="">
                            </a>
                        </div>

                        <div class="header-nav_icon" style="margin-right: 10px;">
                            <a href="https://instagram.com/beruvdom?igshid=YmMyMTA2M2Y=" target="_blank">
                                <i style=" margin-top: 2px; " class="fa-brands fa-instagram"></i>
                            </a>
                        </div>

                        <div class="header-nav_search">
                            <form action="{{route('search')}}" autocomplete="off">
                                <div class="search-wrapper">
                                    <div class="input-holder">
                                        <input type="text" name="s" id="typeahead" class="search-input"
                                               placeholder="Поиск по сайту"/>
                                        <div class="search-icon">
                                            <button>
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span class="close"></span>
                                </div>
                            </form>
                        </div>
                    </div>
                   <div class="header-line_right__info header-line_right__info2" style="margin-left: 60px;">
                        <!--  <a class="subtitle" href="tel:+7 (495) 023-05-15" onclick="ym(87516133,'reachGoal','click on the phone number'); return true;">+7 (495) 023-05-15</a> -->
                        <a class="subtitle" href="tel:+7 (495) 023-05-15" onclick="ym(87516133,'reachGoal','click on the phone number'); return true;">
                            <small style="display: flex; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit;">
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.923077;">+</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.923077;">7</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.846154;">(</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.769231;">4</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.692308;">9</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.615385;">5</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.538462;">)</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.461538;">0</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.384615;">2</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.307692;">3</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.230769;">0</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.153846;">5</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0.0769231;">1</small>
                                <small style="display: inline; margin: 0px; padding: 0px; font-size: inherit; color: inherit; line-height: inherit; opacity: 0;">5</small></small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

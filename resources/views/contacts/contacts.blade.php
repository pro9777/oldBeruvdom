@extends('layout')
@section('page-title', $page->seo_title ?? '')
@section('description', $page->seo_description ?? '')
@section( 'keywords', $page->seo_keywords ?? '')

@section('content')
    <section class="contacts">
        <div class="title">Наши контакты</div>
        <div class="container">
            <div class="contacts-cont">
                <div class="row">
                    <div class="col-lg-4 contacts-left">
                        <ul>
                            <li><a class="subtitle" href="tel:+7 (495) 023-05-15">+7 (495) 023-05-15</a></li>
                            <li><a class="subtitle" href="tel:+7 (495) 023-05-15">info@beruvdom.ru</a></li>
                            <li>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="working-title">Магазин:</div>
                                        <div class="working-subtitle">с 10:00 до 20:00 без выходных</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="working-title">Конструкторское бюро:</div>
                                        <div class="working-subtitle">с 10:00 до 18:00 будни</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="working-title">Склад:</div>
                                        <div class="working-subtitle">с 10:00 до 18:00 будни</div>
                                    </div>

                                    <div class="col-12">
                                        <div class="working-title">Салон:</div>
                                        <div class="working-subtitle"><a style="display:block;font-weight: 300" target="_blank" href="https://yandex.ru/maps/213/moscow/?ll=37.481170%2C55.843574&amp;mode=search&amp;poi%5Bpoint%5D=37.480102%2C55.843157&amp;poi%5Buri%5D=ymapsbm1%3A%2F%2Forg%3Foid%3D237980524462&amp;sctx=ZAAAAAgCEAAaKAoSCdMyUu%2BpiEJAEUm6ZvLNEExAEhIJt3pOet%2F4ij8RigYpeAq5cj8iBgABAgMEBSgKOABAnZIHSAFqAnJ1nQHNzEw9oAEAqAEAvQEpS%2F3iwgEStpD0woQHycfvxMEE%2FILW5owE6gEA8gEA%2BAEAggKiAdCY0L3RgtC10YDRjNC10YAg0YbQtdC90YLRgCDCq9CS0L7QtNC90YvQucK7INCb0LXQvdC40L3Qs9GA0LDQtNGB0LrQvtC1INGI0L7RgdGB0LUgNTjRgSA3LCDRhtC%2B0LrQvtC70YzQvdGL0Lkg0Y3RgtCw0LYg0KHQsNC70L7QvTog0YHQtdC60YbQuNGPIDAxMS0wMTMsINCzLtCc0L7RgYoCAJICAzIxM5oCDGRlc2t0b3AtbWFwcw%3D%3D&amp;sll=37.481170%2C55.843574&amp;sspn=0.008335%2C0.002914&amp;text=%D0%98%D0%BD%D1%82%D0%B5%D1%80%D1%8C%D0%B5%D1%80%20%D1%86%D0%B5%D0%BD%D1%82%D1%80%20%C2%AB%D0%92%D0%BE%D0%B4%D0%BD%D1%8B%D0%B9%C2%BB%20%D0%9B%D0%B5%D0%BD%D0%B8%D0%BD%D0%B3%D1%80%D0%B0%D0%B4%D1%81%D0%BA%D0%BE%D0%B5%20%D1%88%D0%BE%D1%81%D1%81%D0%B5%2058%D1%81%207%2C%20%D1%86%D0%BE%D0%BA%D0%BE%D0%BB%D1%8C%D0%BD%D1%8B%D0%B9%20%D1%8D%D1%82%D0%B0%D0%B6%20%D0%A1%D0%B0%D0%BB%D0%BE%D0%BD%3A%20%D1%81%D0%B5%D0%BA%D1%86%D0%B8%D1%8F%20011-013%2C%20%D0%B3.%D0%9C%D0%BE%D1%81&amp;z=17.62">Интерьер центр «Водный» Ленинградское шоссе 58с 7, цокольный этаж
                                                Салон: секция 011-013,
                                                г.Москва</a></div>
                                    </div>

                                    <div class="col-12">
                                        <div class="working-title">Главный офис:</div>
                                        <div class="working-subtitle"><a style="display:block;font-weight: 300" target="_blank" href="https://yandex.ru/maps/213/moscow/house/1_y_kotlyakovskiy_pereulok_3/Z04YcARoTkQOQFtvfXp1eHRiYQ==/?ll=37.638718%2C55.649815&amp;z=16.96">115201. Москва
                                                ул. 1-й Котляковский переулок
                                                дом 3, офис 49</a></div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-8">
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
            </div>
        </div>
    </section>
@endsection

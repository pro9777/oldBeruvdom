@extends('layout')
@section('page-title', $category->seo_title ?? '')
@section('description', $category->seo_description ?? '')
@section( 'keywords', $category->seo_keywords ?? '')
@section('content')

    <section class="hits">
        <div class="container">
            <div class="title">Поиск по запросу: <b>{{$q}}</b></div>
                <div class="row hits-items">
                    @foreach($products as $product)
                        <div class="col-6 col-md-3 hits-items_item2 data-id" data-id="{{$product->id}}">
                            <div class="hits-items_item2_cont">
                                <a href="{{$product->category->alias}}/{{$product->alias}}">
                                    <div class="hits-items_item__slider hits-items_item__slider_t">
                                        @foreach($product->attachment as $image)
                                            @if($image->group == 'product_photo')
                                                <div class="hits-items_item__slider__img @if($product->category->id === 22) hits-items_item__slider__img--contain @endif"
                                                     style="background-image: url('{{$image->relativeUrl}}'); @if($product->category->id === 23) background-size: contain; @endif">
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
                                            @if($product->price)
                                                <span class="add_cart"><img src="../img/icons/basked.png"
                                                                            alt=""></span>
                                                <div class="hits-items_item__subtitle">
                                                    <span>{{$product->price}} ₽ {{'/' . $product->measurement ?? ''}}</span>
                                                    @if($product->old_price)
                                                        <p>Старая цена: <s>{{$product->old_price}} ₽</s></p>
                                                    @endif
                                                </div>
                                            @else
                                                <a href="{{$product->category->alias}}/{{$product->alias}}"
                                                   class="calculator-addcart calculator-category">рассчитать</a>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach

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

                                    <div class="hits-items_item__title">Не нашли нужного варианта? Отправьте запрос
                                        на изготовление по индивидуальным размерам.
                                    </div>
                                </div>
                            </a>
                            <a href="" class="calculator-addcart calculator-category open-modal"
                               data-modal="mymodal3" style="width: 160px;">запрос менеджеру</a>
                        </div>
                    </div>
                </div>
                {{ $products->links() }}
        </div>
    </section>

@endsection

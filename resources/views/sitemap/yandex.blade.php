<?php echo '<?xml version="1.0"?>'; ?>
<yml_catalog date="{{$dt = \Carbon\Carbon::now()->toIso8601String()}}">
    <shop>
        <name>BERUVDOM.RU</name>
        <company>beruvdom.ru</company>
        <url>{{URL::to('/')}}/</url>
        <platform>BSM/Yandex/Market</platform>
        <categories>
            @foreach($categories as $category)
                <category id="{{$category->id}}">{{$category->title}}</category>

            @endforeach

        </categories>
        {{--        <delivery-options>--}}
        {{--            <option cost="200" days="1"/>--}}
        {{--        </delivery-options>--}}
        {{--        <pickup-options>--}}
        {{--            <option cost="200" days="1"/>--}}
        {{--        </pickup-options>--}}
        <offers>
            @foreach($products as $product)
                <offer id="{{$product->id}}">
                    <name>{{$product->title}}</name>
                    <vendor>{{$product->brend}}</vendor>
                    <vendorCode>{{$product->articular ?? $product->id }}</vendorCode>
                    <url>{{URL::to('/') . '/' . $product->category->alias . '/' . $product->alias}}</url>
                    <price>{{$product->price}}</price>
                    <oldprice>{{$product->old_price}}</oldprice>
                    <enable_auto_discounts>true</enable_auto_discounts>
                    <currencyId>RUR</currencyId>
                    <categoryId>{{$product->parent_id}}</categoryId>
                    @foreach($product->attachment()->where('group', 'product_photo')->get() as $image)
                        <picture>{{URL::to('/') . '/' .$image->relativeUrl ?? ''}}</picture>
                    @endforeach
                    @foreach($product->attachment()->where('group', 'product_gallery')->get() as $image)
                        <picture>{{URL::to('/') . '/' .$image->relativeUrl ?? ''}}</picture>
                    @endforeach
                    <description>
                        <![CDATA[
                        {!! $product->description2 !!}
                        ]]>
                    </description>
                    {{--                    <sales_notes>Необходима предоплата.</sales_notes>--}}
                    <manufacturer_warranty>true</manufacturer_warranty>
                    {{--                    <barcode>4601546021298</barcode>--}}
                    {{--                    <param name="Цвет">белый</param>--}}
                    {{--                    <weight>3.6</weight>--}}
                    {{--                    <dimensions>20.1/20.551/22.5</dimensions>--}}
                    <condition type="preowned">
                        <quality>excellent</quality>
                    </condition>
                </offer>
            @endforeach

        </offers>
    </shop>
</yml_catalog>

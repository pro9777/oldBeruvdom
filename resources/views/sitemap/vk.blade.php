<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<yml_catalog date="{{$dt = \Carbon\Carbon::now()}}">
    <shop>
        <name>vk.com</name>
        <company>vk.com</company>
        <url>https://vk.com/</url>
        <currencies>
            <currency id="RUB" rate="1"/>
        </currencies>
        <categories>
            @foreach($categories as $category)
                <category id="{{$category->id}}">{{$category->title}}</category>
            @endforeach
        </categories>
        <offers>
            @foreach($products as $product)
                <offer id="{{$product->id}}" available="true">
                    <price>{{$product->price}}</price>
                    <currencyId>RUB</currencyId>
                    <categoryId>{{$product->parent_id}}</categoryId>
                    <name>{{$product->title}}</name>
                    <description>
                        <![CDATA[
                        {!! $product->description2 !!}
                        ]]>
                    </description>
                    @foreach($product->attachment()->where('group', 'product_photo')->get() as $image)
                        <picture>{{URL::to('/') . '/' .$image->relativeUrl ?? ''}}</picture>
                    @endforeach
                    @foreach($product->attachment()->where('group', 'product_gallery')->get() as $image)
                        <picture>{{URL::to('/') . '/' .$image->relativeUrl ?? ''}}</picture>
                    @endforeach
                </offer>
            @endforeach
        </offers>
    </shop>
</yml_catalog>

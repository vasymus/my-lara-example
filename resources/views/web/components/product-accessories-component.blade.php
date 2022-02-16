<?php
/** @var \Domain\Products\Models\Product\Product $product */
?>
@if(count($product->accessory))
<div {{ $attributes->merge(["class" => "accessories-block"]) }}>
    <h4 class="accessories-block__title-orange">{{$product->accessory_name}} <img src="{{asset('images/arr-orange-down.gif')}}" alt=""></h4>
    <div class="row-line">
        @foreach($product->accessory as $accessoryItem)
            <?php /** @var \Domain\Products\Models\Product\Product $accessoryItem */ ?>
            <div class="column">
                <div class="row-line">
                    <a href="{{$accessoryItem->web_route}}">
                        <img alt="{{$accessoryItem->name}}" width="40" height="40" src="{{$accessoryItem->main_image_url}}">
                    </a>
                    <div class="product-special">
                        <p>
                            <a href="{{$accessoryItem->web_route}}">{{$accessoryItem->name}}</a><br>
                            <span class="accessories-block__cost-orange">{{$accessoryItem->price_retail_rub_formatted}}</span>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

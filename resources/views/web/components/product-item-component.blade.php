<?php /** @var \Domain\Products\Models\Product\Product $product */ ?>
<div class="catalog__post js-product-item-component-{{$product->id}}">
    <h3 class="catalog__title"><a href="{{$route()}}" class="catalog__link">{!! $product->name !!}</a></h3>
    <div class="row-line">
        <div class="column-photo">
            <div class="catalog__photo">
                <a href="{{$route()}}"><img style="max-width: 120px;" src="{{$mainImageMdThumb()}}" alt="{{ strip_tags($product->name) }}" class="catalog__image"></a>
            </div>
            <div class="put-off-block">
                <a href="#" data-id="{{$product->id}}" class="js-put-aside put-off-block__link {{in_array($product->id, $asideIds) ? "put-off-block__link--active" : ""}}">
                    <i class="fa fa-bookmark" aria-hidden="true"></i>
                    {{in_array($product->id, $asideIds) ? "Отложено" : "Отложить" }}
                </a>
            </div>
        </div>
        <div class="column-text">
            {!! $product->preview !!}

            <div class="catalog__product-variants">
                <a href="{{$route()}}" class="catalog__variant-link">
                    <span class="desktop-visible">Варианты этого товара <img src="{{asset('images//variants-arrow.png')}}" width="20" height="14"></span>
                    <span class="mob-visible">Подробнее</span>
                </a>
            </div>
        </div>


        <div class="column-price-block {{\Support\H::userOrAdmin()->is_admin ? 'js-product-item-popover' : ''}}" @if(\Support\H::userOrAdmin()->is_admin) data-content="<p>Закупочная: {{$product->price_purchase_rub_formatted}}</p><p>Маржа: {{$product->margin_rub_formatted}}</p><p>Наценка: {{$product->price_markup}} %</p><p>Заработок: {{$product->price_income}} %</p><p>{{$product->admin_comment}}</p> <p><a href='{{route(\App\Constants::ROUTE_ADMIN_PRODUCTS_EDIT, $product->id)}}' target='_blank'>Редактировать</a></p>" @endif>
            <span class="catalog__price-title">{{$product->price_name}}:</span>
            <span class="catalog__price">{{$product->price_retail_rub_formatted}} <span class="gray-color"> / {{$product->unit}}</span></span>
            <span class="catalog__status {{$product->is_available ? 'catalog__status--available' : 'catalog__status--not-available'}}">{{$product->availability_status_name}}</span>

            @if($product->is_available)
            <a href="{{$product->web_route}}" class="catalog__addToCard">Купить</a>
            @endif

            @if(!empty($product->coefficient) && (int)$product->coefficient !== 0)
                <div class="price-bottom">
                    @if(!empty($product->coefficient_description))<div class="price-bottom__text">{{$product->coefficient_description}}</div>@endif
                    <div class="price-bottom__currency">{{$product->coefficient_price_rub_formatted}}</div>
                </div>
            @endif

            @foreach($infoPrices as $infoPrice)
                <div class="price-bottom">
                    <div class="price-bottom__text">{{$infoPrice["name"]}}</div>
                    <div class="price-bottom__currency" style="color:#ff5100;">{{$infoPrice["priceFormatted"]}}</div>
                </div>
            @endforeach
        </div>

        <div class="column-price-mobile">
            <div class="column">
                <span class="catalog__price">{{$product->price_retail_rub_formatted}}<span class="gray-color"> / {{$product->unit}}</span></span>
            </div>
            <div class="column">
                <a href="{{$product->web_route}}" class="catalog__addToCard">Купить</a>
            </div>
        </div>
    </div>
    <div class="catalog__number">{{ $orderNumber() }}</div>
</div>

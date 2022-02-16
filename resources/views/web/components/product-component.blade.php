<?php /** @var \Domain\Products\Models\Product\Product $product */ ?>
<div class="content__white-block">
    <h2 class="product__title">{!! $product->name !!}</h2>

    <div class="put-product row-line row-line__between">
        <div class="put-off-block">
            <a href="#" data-id="{{$product->id}}" class="js-put-aside put-off-block__link {{in_array($product->id, $asideIds) ? "put-off-block__link--active" : ""}}">
                <i class="fa fa-bookmark" aria-hidden="true"></i>
                {{in_array($product->id, $asideIds) ? "Отложено" : "Отложить" }}
            </a>
        </div>

        @include("web.components.includes.product.instructions", ["instructions" => $instructions()])
    </div>

    {{-- Product line --}}
    @if($isWithVariations())
        <div class="row-line product-line">
            <div class="column">
                @include("web.components.includes.product.main-image", ["mainImage" => $mainImage(), "mainImageThumb" => $mainImageLgThumb(), "productName" => $product->name])
            </div>
            <div class="column">
                @include("web.components.includes.product.brand", ["brand" => $product->brand])

                @include("web.components.includes.product.images-thumbs", ["imagesUrls" => $imagesUrls(), "imagesThumbs" => $imagesXsUrls()])
            </div>
        </div>
    @endif

    @if(! $isWithVariations())
        <div class="row-line product-line">
            <div class="column">
                @include("web.components.includes.product.main-image", ["mainImage" => $mainImage(), "mainImageThumb" => $mainImageLgThumb(), "productName" => $product->name])

                @include("web.components.includes.product.images-thumbs", ["imagesUrls" => $imagesUrls(), "imagesThumbs" => $imagesXsUrls()])
            </div>
            <div class="column">
                <div class="product-price">
                    <div class="product-price__top row-line row-line__center row-line__jc-center">
                        <span class="product-price__subtitle">{{ $product->price_name }}</span>
                    </div>
                    <div class="product-price__top row-line row-line__center row-line__jc-center">
                        <div class="column-price">
                            <span class="product-price__count-block">{{ $product->price_retail_rub_formatted }}</span>
                        </div>
                        <div class="column-price">
                            <span class="product-price__count-block-gray">/ {{$product->unit}}</span>
                        </div>
                    </div>
                    <div class="product-price__body row-line row-line__between">
                        @if($product->is_available)
                        <div class="column-price-part">
                            <span class="product-price__subtitle">Количество</span>
                            <input
                                type="number"
                                min="1"
                                class="
                                    js-add-to-cart-input-count-{{$product->id}}
                                    js-input-hide-on-focus
                                    product-price__count
                                    js-add-to-cart-input-instant-highlighted
                                    js-keyup-validate
                                    {{$product->is_in_cart ? "input-highlighted" : ""}}
                                "
                                data-id="{{$product->id}}"
                                value="{{$product->cart_count ?? 1}}"
                            />
                        </div>
                        @endif
                        @if($product->is_available)
                        <div class="column-price-part">
                            <div class="available-blocker">
                                <i class="fa fa-check-circle" aria-hidden="true"></i>
                                В наличии
                            </div>
                            <button
                                type="button"
                                class="js-add-to-cart product-price__add {{$product->is_in_cart ? "is-in-cart" : ""}} {{ $product->is_available_in_stock ? "available-in-stock" : "" }} {{$product->is_available_not_in_stock ? "available-not-in-stock" : ""}}"
                                data-id="{{$product->id}}"
                                data-is-in-cart="{{(int)$product->is_in_cart}}"
                            >{{$product->is_in_cart ? "Добавить" : "В корзину"}}</button>
                        </div>
                        @else
                            <div class="available-blocker">
                                <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                Нет в наличии
                            </div>
                        @endif
                    </div>
                    <div class="product-price__description">
                        {{$product->coefficient_description}} - {{$product->coefficient_price_rub_formatted}}
                    </div>
                </div>

                @include("web.components.includes.product.brand", ["brand" => $product->brand])
            </div>
        </div>
    @endif
    {{-- END Product line --}}


    {{-- Если товар с вариантами --}}
    @if($isWithVariations())
        <div class="product-variants">
            <table width="100%" cellspacing="0" cellpadding="7" border="0">
                <thead>
                    <tr>
                        <th colspan="2">Варианты:</th>
                        <th>{{$product->coefficient_variation_description}}</th>
                        <th>Цена</th>
                        <th>Уп-ка</th>
                        <th>Кол-во</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($product->variations as $index => $variation)
                    <?php /** @var \Domain\Products\Models\Product\Product $variation */ ?>
                <tr>
                    <td>
                        <div class="product-variants__photo {{ $variation->main_image_url ? '' : 'img-none' }}">
                            @if($variation->main_image_url)
                                <a
                                    href="{{$variation->main_image_url}}"
                                    data-fancybox="variation-image-link-loop-{{$index + 1}}"
                                >
                                    <img
                                        src="{{$variation->main_image_sm_thumb_url}}"
                                        alt="{{$variation->name}}"
                                        title="{{$variation->name}}">
                                </a>
                            @endif
                            <span class="product-variants__counter">{{$index + 1}}</span>
                            @if($variation->main_image_url)
                                <a
                                    class="product-variants__zoom"
                                    href="javascript:;"
                                    data-fancybox-trigger="variation-image-link-loop-{{$index + 1}}"
                                ></a>
                            @endif
                            @foreach($variation->images_urls as $url)
                                <a
                                    href="{{$url}}"
                                    data-fancybox="variation-image-link-loop-{{$index + 1}}"
                                    style="display: none;"
                                ></a>
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <h3 class="product-variants__title">
                            <a
                                href="javascript:void(0)"
                                class="js-manual-tooltip"
                                data-placement="top"
                                data-timeout="6000"
                                data-title="{!! trim($variation->preview) !!}"
                                data-html="true"
                                data-trigger="manual"
                                data-class="tooltip-variants"
                            >{{$variation->name}}</a>
                        </h3>
                    </td>
                    <td>
                        @if(!empty($variation->coefficient) && (int)$variation->coefficient !== 0)
                            @if(!empty($variation->coefficient_description))
                                <div>{{$variation->coefficient_description}}</div>
                            @endif
                            <div>
                                <strong class="product-variants__price-blue" style="white-space: nowrap;">{{$variation->coefficient_price_rub_formatted}}</strong>
                            </div>
                        @else
                            &nbsp;
                        @endif
                    </td>
                    <td width="10%">
                        <strong class="product-variants__price-orange">{{$variation->price_retail_rub_formatted}}</strong>
                    </td>
                    <td>
                        <strong class="product-variants__price-gray">{{$variation->unit}}</strong>
                    </td>
                    <td width="10%">
                        @if($variation->is_available)
                        <input
                            type="number"
                            value="{{$variation->cart_count ?? 1}}"
                            min="1"
                            class="
                            product-variants__input_small
                            js-add-to-cart-input-count-{{$variation->id}}
                            js-input-hide-on-focus
                            js-add-to-cart-input-instant-highlighted
                            js-keyup-validate
                            {{$variation->is_in_cart ? "input-highlighted" : ""}}
                            "
                            data-id="{{$variation->id}}"
                        />
                        @endif
                    </td>
                    <td width="10%" align="right">
                        @if($variation->is_available)
                            <button
                                class="
                                {{ $variation->is_available_in_stock ? "red-color" : "" }}
                                {{$variation->is_available_not_in_stock ? "color-orange" : ""}}
                                js-add-to-cart
                                button-buy
                                addToCart
                                {{$variation->is_in_cart ? "is-in-cart" : ""}}
                                "
                                type="button"
                                data-id="{{$variation->id}}"
                                data-is-in-cart="{{(int)$variation->is_in_cart}}"
                            >
                                {{$variation->is_in_cart ? "Добавить" : $variation->available_submit_label}}
                            </button>
                        @else
                            <strong>{{$variation->available_submit_label}}</strong>
                        @endif
                    </td>
                </tr>
                    @if(\Support\H::userOrAdmin()->is_admin)
                <tr class="alert fade show">
                    <td colspan="7">
                        <div class="manager-area-price">
                            <p>
                                Закупочная: <strong>{{$variation->price_purchase_rub_formatted}}</strong>,
                                Маржа: <span>{{$variation->margin_rub_formatted}}</span>,
                                Наценка: {{$variation->price_markup}} %,
                                Заработок: {{$variation->price_income}} %
                                Редактирование <a href="{{$variation->admin_route}}" target="_blank">в админке</a>
                            </p>
                            <button type="button" data-dismiss="alert" aria-label="Close">X</button>
                        </div>
                    </td>
                </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <div class="mob-products">
                <h3>Варианты</h3>
                @foreach($product->variations as $variation)
                <div class="over-line">
                    <div class="column">
                        <div class="{{ $variation->main_image_url ? 'product-variants__photo' : 'product-variants__photo img-none' }}">
                            @if($variation->main_image_url)
                                <a href="{{$variation->main_image_url}}" data-fancybox="variation-image-loop-mobile-{{$loop->index + 1}}">
                                    <img
                                        src="{{$variation->main_image_sm_thumb_url}}"
                                        alt="{{$variation->name}}"
                                        title="{{$variation->name}}" />
                                </a>
                            @endif
                            <span class="product-variants__counter">{{$loop->index + 1}}</span>
                            @if($variation->main_image_url)
                                <a href="javascript:;" data-fancybox-trigger="variation-image-loop-mobile-{{$loop->index + 1}}" class="product-variants__zoom"></a>
                            @endif
                        </div>
                    </div>
                    <div class="column">
                        <div class="block-text-product">
                            <h4 class="product-variants__title">
                                <a
                                    href="javascript:void(0)"
                                    data-timeout="6000"
                                    class="pointer link-text js-manual-tooltip"
                                    data-placement="top"
                                    data-title="{!! $variation->preview !!}"
                                    data-html="true"
                                    data-trigger="manual"
                                    data-class="tooltip-variants"
                                >{{$variation->name}}</a>
                            </h4>
                            <div class="line-product right">
                                <span class="text-orange">{{$variation->price_retail_rub_formatted}} <span class="text-gray">/ {{$variation->unit}}</span></span>
                            </div>

                            @if($variation->is_available)
                            <div class="product-amount row-line">
                                <div class="column">
                                    <input
                                        type="number"
                                        value="{{$variation->cart_count ?? 1}}"
                                        min="1"
                                        class="
                                        product-variants__input_small
                                        js-add-to-cart-input-count-{{$variation->id}}
                                        js-input-hide-on-focus
                                        js-add-to-cart-input-instant-highlighted
                                        js-keyup-validate
                                        {{$variation->is_in_cart ? "input-highlighted" : ""}}
                                        "
                                        data-id="{{$variation->id}}"
                                    />
                                </div>
                                <div class="column">
                                    <button
                                        class="
                                        {{ $variation->is_available_in_stock ? "red-color" : "" }}
                                        {{$variation->is_available_not_in_stock ? "color-orange" : ""}}
                                            js-add-to-cart
                                            add-basket
                                            {{$variation->is_in_cart ? "is-in-cart" : ""}}
                                        "
                                        type="button"
                                        data-id="{{$variation->id}}"
                                        data-is-in-cart="{{(int)$variation->is_in_cart}}"
                                    >
                                        {{$variation->is_in_cart ? "Добавить" : $variation->available_submit_label}}
                                    </button>
                                </div>
                            </div>
                            @else
                                <div class="product-amount">
                                    <strong>{{$variation->available_submit_label}}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="characteristics">

        <x-product-accessories :product="$product" class="hidden-desktop"></x-product-accessories>

        <div class="tab-container">
            <ul class="nav tabs row-line" id="product-descr-chars-tabs-mobile" role="tablist">
                <li role="presentation">
                    <a
                        href="#product-descr-tab-pane-mobile"
                        id="product-descr-tab"
                        class="active"
                        data-toggle="tab"
                        role="tab"
                        aria-controls="product-descr-tab-pane-mobile"
                        aria-selected="true"
                    >Описание</a>
                </li>
                @if(!$product->characteristicsIsEmpty())
                    <li role="presentation">
                        <a
                            href="#product-chars-tab-pane-mobile"
                            id="product-chars-tab"
                            class=""
                            data-toggle="tab"
                            role="tab"
                            aria-controls="product-chars-tab-pane-mobile"
                            aria-selected="false"
                        >Характеристики</a>
                    </li>
                @endif
            </ul>
            <div class="tab-panes" id="product-descr-chars-tab-panes-mobile">
                <div class="tab-pane active" id="product-descr-tab-pane-mobile" role="tabpanel" aria-labelledby="product-descr-tab">
                    <h3>{!! $product->name !!}</h3>
                    @if($product->description)
                        {!! $product->description !!}
                    @else
                        {!! $product->preview !!}
                    @endif
                </div>
                @if(!$product->characteristicsIsEmpty())
                    <div class="tab-pane" id="product-chars-tab-pane-mobile" role="tabpanel" aria-labelledby="product-chars-tab">
                        <h3>характеристики: {!! $product->name !!}</h3>
                        <x-product-chars-props :product="$product"></x-product-chars-props>
                    </div>
                @endif
            </div>
        </div>

        <div class="desktop-characteristics">
            <ul class="nav nav-tabs tab-list">
                <li class="active"><a href="#tab1">Описание</a></li>
                @if(!$product->characteristicsIsEmpty())
                    <li><a href="#tab2">Характеристики</a></li>
                @endif
            </ul>
            <div class="characteristics__content" id="tab1">
                <h3>{!! $product->name !!}</h3>
                @if($product->description)
                    {!! $product->description !!}
                @else
                    {!! $product->preview !!}
                @endif
            </div>

            <x-product-accessories :product="$product"></x-product-accessories>

            @if(!$product->characteristicsIsEmpty())
                <div class="characteristics__content" id="tab2">
                    <h3>характеристики: {!! $product->name !!}</h3>
                    <x-product-chars-props :product="$product"></x-product-chars-props>
                </div>
            @endif
        </div>

        <div class="block-green">
            <p>{!! $product->name !!} в магазине, Вы можете купить {!! $product->name !!}, узнайте подробные технические характеристики и цену на {!! $product->name !!}, фотографии и отзывы посетителей помог1ут Вам определиться с покупкой, {!! $product->name !!} - закажите с доставкой на дом.</p>
        </div>

    </div>

</div>

<div class="content-sliders">
    @if($product->similar->isNotEmpty())
        <div class="slider-blocker">
            <div class="slider-blocker__header row-line row-line__between swiper-container">
                <h2 class="slider-blocker__header-title">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                    {{$product->similar_name}}
                </h2>
                <div class="block-arrow">
                    <div class="swiper-button-prev btn-slider js-slider-btn-1">
                        <i class="fa fa-arrow-left"></i>
                    </div>
                    <div class="swiper-button-next btn-slider js-slider-btn-1">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </div>
            </div>

            <div class="swiper-block">
                <div class="swiper-container js-slider-1 swiper-container-initialized swiper-container-horizontal">
                    <div class="swiper-wrapper">
                        @foreach($product->similar as $item)
                            <?php /** @var \Domain\Products\Models\Product\Product $item */ ?>
                            <div class="swiper-slide">
                                <div class="slider-blocker__item">
                                    <h3 class="slider-blocker__title"><a class="slider-blocker__link" href="{{$item->web_route}}">{!! $item->name !!}</a></h3>
                                    <div class="slider-blocker__photo">
                                        <a href="{{$item->web_route}}"><img src="{{$item->main_image_url}}" alt=""></a>
                                    </div>
                                    <div class="slider-blocker__text-center">
                                        <span class="slider-blocker__cost">{{$item->price_retail_rub_formatted}}</span>
                                        <a href="{{$item->web_route}}" class="slider-blocker__buy">купить</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($product->related->isNotEmpty())
        <div class="slider-blocker">
            <div class="slider-blocker__header row-line row-line__between swiper-container">
                <h2 class="slider-blocker__header-title">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                    {{$product->related_name}}
                </h2>
                <div class="block-arrow">
                    <div class="swiper-button-prev btn-slider js-slider-btn-2">
                        <i class="fa fa-arrow-left"></i>
                    </div>
                    <div class="swiper-button-next btn-slider js-slider-btn-2">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </div>
            </div>

            <div class="swiper-block">
                <div class="swiper-container js-slider-2 swiper-container-initialized swiper-container-horizontal">
                    <div class="swiper-wrapper">
                        @foreach($product->related as $item)
                            <?php /** @var \Domain\Products\Models\Product\Product $item */ ?>
                            <div class="swiper-slide">
                                <div class="slider-blocker__item">
                                    <h3 class="slider-blocker__title"><a class="slider-blocker__link" href="#">{!! $item->name !!}</a></h3>
                                    <div class="slider-blocker__photo">
                                        <a href="#"><img src="{{$item->main_image_url}}" alt=""></a>
                                    </div>
                                    <div class="slider-blocker__text-center">
                                        <span class="slider-blocker__cost">{{$item->price_retail_rub_formatted}}</span>
                                        <a href="{{$item->web_route}}" class="slider-blocker__buy">купить</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($product->works->isNotEmpty())
        <div class="slider-blocker">
            <div class="slider-blocker__header row-line row-line__between swiper-container">
                <h2 class="slider-blocker__header-title">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                    {{$product->work_name}}
                </h2>
                <div class="block-arrow">
                    <div class="swiper-button-prev btn-slider js-slider-btn-3">
                        <i class="fa fa-arrow-left"></i>
                    </div>
                    <div class="swiper-button-next btn-slider js-slider-btn-3">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </div>
            </div>

            <div class="swiper-block">
                <div class="swiper-container js-slider-3 swiper-container-initialized swiper-container-horizontal">
                    <div class="swiper-wrapper">
                        @foreach($product->works as $item)
                            <?php /** @var \Domain\Products\Models\Product\Product $item */ ?>
                            <div class="swiper-slide">
                                <div class="slider-blocker__item">
                                    <h3 class="slider-blocker__title"><a class="slider-blocker__link" href="#">{!! $item->name !!}</a></h3>
                                    <div class="slider-blocker__photo">
                                        <a href="#"><img src="{{$item->main_image_url}}" alt=""></a>
                                    </div>
                                    <div class="slider-blocker__text-center">
                                        <span class="slider-blocker__cost">{{$item->price_retail_rub_formatted}}</span>
                                        <a href="{{$item->web_route}}" class="slider-blocker__buy">купить</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($product->instruments->isNotEmpty())
        <div class="slider-blocker">
            <div class="slider-blocker__header row-line row-line__between swiper-container">
                <h2 class="slider-blocker__header-title">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                    {{$product->instruments_name}}
                </h2>
                <div class="block-arrow">
                    <div class="swiper-button-prev btn-slider js-slider-btn-3">
                        <i class="fa fa-arrow-left"></i>
                    </div>
                    <div class="swiper-button-next btn-slider js-slider-btn-3">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </div>
            </div>

            <div class="swiper-block">
                <div class="swiper-container js-slider-3 swiper-container-initialized swiper-container-horizontal">
                    <div class="swiper-wrapper">
                        @foreach($product->instruments as $item)
                            <?php /** @var \Domain\Products\Models\Product\Product $item */ ?>
                            <div class="swiper-slide">
                                <div class="slider-blocker__item">
                                    <h3 class="slider-blocker__title"><a class="slider-blocker__link" href="#">{!! $item->name !!}</a></h3>
                                    <div class="slider-blocker__photo">
                                        <a href="#"><img src="{{$item->main_image_url}}" alt=""></a>
                                    </div>
                                    <div class="slider-blocker__text-center">
                                        <span class="slider-blocker__cost">{{$item->price_retail_rub_formatted}}</span>
                                        <a href="{{$item->web_route}}" class="slider-blocker__buy">купить</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="sidebar-basket-block js-sidebar-menu-cart" @if(!count($cartProducts)) style="display: none;" @endif>
    <div class="sidebar-basket-block__title"><a href="{{route("cart.show")}}">Ваша корзина</a></div>
    <div class="sidebar-basket-block__body">
        <div class="js-sidebar-menu-cart-list">
            @foreach($cartProducts as $cartProduct)
                <?php /** @var \Domain\Products\Models\Product\Product $cartProduct */ ?>
                <div class="sidebar-basket-block__cartitem" data-id="{{$cartProduct->id}}">
                    <h4><a href="{{$cartProduct->web_route}}">{!! $cartProduct->name !!}</a></h4>
                    <div class="sidebar-basket-block__price">
                        <span class="sidebar-basket-block__qty">{{ $cartProduct->cart_product->count ?? 1 }} шт</span>
                        {{$cartProduct->price_name}}: <strong class="sidebar-basket-block__text-orange">{{$cartProduct->price_retail_rub_formatted}}</strong>
                        <strong> / {{$cartProduct->unit}}</strong>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="sidebar-basket-block__cartresume">
            <h5>Сумма: <span class="js-cart-total-sum-formatted">{{$totalSumFormatted}}</span></h5>
            <div class="sidebar-basket-block__cart_block_button">
                <a href="{{route("cart.show")}}">Перейти в корзину</a>
            </div>
        </div>
    </div>
</div>

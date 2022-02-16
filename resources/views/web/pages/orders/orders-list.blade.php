<?php /** @var \Illuminate\Pagination\LengthAwarePaginator $orders */ ?>
    <x-go-back/>
<div class="content__white-block">
    <div class="cabinet desktop">
        <h2 class="cabinet__title">Мои последние заказы</h2>
        <?php /** @var \Domain\Orders\Models\Order $order */ ?>
        @foreach($orders as $order)
            <div class="product-selling">
                <div class="product-selling__header">
                    <a class="product-selling__link" href="{{route("orders.show", $order->id)}}">Заказ # {{$order->id}}</a>
                    @if($order->created_at instanceof \Carbon\Carbon)
                        <span class="product-selling__date">от {{$order->created_at->format("d.m.Y")}}</span>
                    @endif
                    <span class="product-selling__text">Сумма <em>{{$order->order_price_retail_rub_formatted}}</em></span>
                    <span class="product-selling__text order">Заказ {{$order->status_name_for_user}}</span>
                    <a class="product-selling__repeat" href="#">Повторить</a>
                </div>
                <div class="product-selling__body">
                    <table class="product-selling__table" cellspacing="0" cellpadding="0">
                        <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Цена</th>
                            <th>Количество</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php /** @var \Domain\Products\Models\Product\Product $product */ ?>
                            @foreach($order->products as $product)
                                <tr>
                                    <td><a href="{{$product->web_route}}">{{$product->name}}</a></td>
                                    <td>{{$product->order_product_price_retail_rub_formatted}}</td>
                                    <td>{{$product->order_product_count}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
    <div class="cabinet mobile">
        <h2 class="cabinet__title">Мои последние заказы</h2>
        @foreach($orders as $order)
            <div class="product-selling">
                <div class="product-selling__header">
                    <a class="product-selling__link" href="{{route("orders.show", $order->id)}}">Заказ # {{$order->id}}</a>
                    @if($order->created_at instanceof \Carbon\Carbon)
                        <span class="product-selling__date">от {{$order->created_at->format("d.m.Y")}}</span>
                    @endif
                    <span class="product-selling__text">Сумма <em>{{$order->order_price_retail_rub_formatted}}</em></span>
                    <span class="product-selling__text order">Заказ {{$order->status_name_for_user}}</span>
                </div>
                <div class="product-selling__body">
                    <table class="product-selling__table" cellspacing="0" cellpadding="0">
                        <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Цена</th>
                            <th>Количество</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php /** @var \Domain\Products\Models\Product\Product $product */ ?>
                            @foreach($order->products as $product)
                                <tr>
                                    <td colspan="3">
                                        <a href="{{$product->web_route}}">{{$product->name}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>{{$product->order_product_price_retail_rub_formatted}}</td>
                                    <td>{{$product->order_product_count}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</div>

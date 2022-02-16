@extends('web.pages.page-layout')

@section('page-content')
    <?php /** @var \Domain\Orders\Models\Order $order */ ?>
    <x-h1 :entity="'Мой заказ №' . $order->id"></x-h1>

    <div class="content__white-block sale-order-detail">
        <h2 class="sale-order-detail__title">Заказ № {{$order->id}} @if($order->created_at instanceof \Carbon\Carbon) от {{$order->created_at->format("d.m.Y H:i:s")}} @endif</h2>
        <div class="row-line">
            <a href="{{route("profile")}}" class="sale-order-detail__link-back">← Вернуться в список заказов</a>
        </div>
        <div class="sale-order-detail">
            <div class="sale-order-detail__head">
                <span class="sale-order-detail__item">Заказ №{{$order->id}} @if($order->created_at instanceof \Carbon\Carbon) от {{$order->created_at->format("d.m.Y H:i:s")}} @endif, {{$order->order_products_count}} товар(а|ов) на сумму {{$order->order_price_retail_rub_formatted}}</span>
            </div>
            <div class="sale-order-detail__container">
                <h3 class="sale-order-detail__subtitle">Информация о заказе</h3>
                <div class="row-line item">
                    <div class="column">
                        <h3 class="sale-order-detail__name-title">Ф.И.О.:</h3>
                        <p class="sale-order-detail__name-detail">{{ $order->user_name }}</p>
                    </div>
                    <div class="column">
                        <h3 class="sale-order-detail__name-title sale-order-detail__name-title--color-gree">Текущий статус@if($order->updated_at instanceof \Carbon\Carbon), от {{$order->updated_at->format("d.m.Y")}}@endif:</h3>
                        <p class="sale-order-detail__name-detail">Заказ {{$order->status_name_for_user}}</p>
                    </div>
                    <div class="column">
                        <h3 class="sale-order-detail__name-title sale-order-detail__name-title--color-gree">Сумма:</h3>
                        <p class="sale-order-detail__name-detail">{{$order->order_price_retail_rub_formatted}}</p>
                    </div>
                    <div class="column">
                        <a href="#" class="sale-order-detail__btn">Повторить заказ</a>
                        <a href="#" class="sale-order-detail__cancel">Отменить</a>
                    </div>
                    <div class="column-full-width">
                        <a href="javascript:void(0);" class="sale-order-detail__read-more">подробнее</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="sale-order-detail__content">
            <div class="order-info">
                <h3 class="order-info__title">Информация о пользователе</h3>
                <div class="order-info__item">
                    <span class="order-info__label">E-mail адрес:</span>
                    <p class="order-info__text"><a href="mailto:{{\Support\H::userOrAdmin()->email}}">{{\Support\H::userOrAdmin()->email}}</a></p>
                </div>
                <div class="order-info__item">
                    <span class="order-info__label">Тип плательщика:</span>
                    <p class="order-info__text">{{$order->payment_type_legal_entity_name ?: "-"}}</p>
                </div>
                <div class="order-info__item">
                    <span class="order-info__label">Имя:</span>
                    <p class="order-info__text">{{\Support\H::userOrAdmin()->name}}</p>
                </div>
                @if($order->initial_attachments->isNotEmpty())
                <div class="order-info__item">
                    <span class="order-info__label">Приложенные файлы:</span>
                    @foreach($order->initial_attachments as $attachment)
                        <p class="order-info__text"><a target="_blank" download href="{{$attachment->getFullUrl()}}">{{$attachment->file_name}}</a></p>
                    @endforeach
                </div>
                @endif
                <div class="order-info__item">
                    <span class="order-info__label">Телефон:</span>
                    <p class="order-info__text">{{$order->user_phone}}</p>
                </div>
                <h3 class="order-info__title">Комментарии к заказу</h3>
                <div class="order-info__item">
                    <p class="order-info__text" style="white-space: pre-line">{{$order->comment_user}}</p>
                </div>
            </div>
        </div>

        <div class="sale-order-detail__head">
            <span class="sale-order-detail__item">Содержимое заказа</span>
        </div>
        <div class="sale-order-detail__container">
            <div class="sale-order-table cabinet desktop">
                <div class="product-selling">
                    <table class="product-selling__table" cellspacing="0" cellpadding="0">
                        <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Цена</th>
                            <th>Количество</th>
                            <th>Сумма</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->products as $product)
                            <tr>
                                <td><a href="{{$product->web_route}}">{{$product->name}}</a></td>
                                <td>{{$product->order_product_price_retail_rub_formatted}}</td>
                                <td>{{$product->order_product_count}}</td>
                                <td><b>{{$product->order_product_price_retail_rub_sum_formatted}}</b></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="sale-order-table cabinet mobile">
                <div class="product-selling">
                    <table class="product-selling__table" cellspacing="0" cellpadding="0">
                        <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Цена</th>
                            <th>Количество</th>
                            <th>Сумма</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->products as $product)
                            <tr>
                                <td colspan="4"><a href="{{$product->web_route}}">{{$product->name}}</a></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>{{$product->order_product_price_retail_rub_formatted}}</td>
                                <td>{{$product->order_product_count}}</td>
                                <td><b>{{$product->order_product_price_retail_rub_sum_formatted}}</b></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <a href="#" class="btn-repeat">Повторить</a>
                </div>
            </div>
        </div>
    </div>
@endsection

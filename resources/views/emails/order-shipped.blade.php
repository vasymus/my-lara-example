<?php /** @var \Domain\Orders\Models\Order $order */ ?>

@extends('emails.layouts.app')

@section('content')
    <h1>Спасибо, что обратились в наш интернет-магазин</h1>
    <p>Ваш заказ номер <b>{{$order->id}}</b> @if($order->created_at instanceof \Carbon\Carbon) от {{$order->created_at->format("d.m.Y")}} @endif обрабатывается.</p>
    <p>Менеджер свяжется с Вами для уточнения способа оплаты и получения заказа.</p>
    <p>Стоимость заказа: <b>{{$order->order_price_retail_rub_formatted}}</b>.</p>
    <p>Состав заказа:</p>
    <div class="table">
        <table>
            <tbody>
                <?php /** @var \Domain\Products\Models\Product\Product $product */ ?>
                @foreach($order->products as $product)
                <tr>
                    <td width="50%"><a href="{{$product->web_route}}">{{$product->name}}</a></td>
                    <td width="25%" align="center">{{$product->order_product_count}} шт. x {{$product->order_product_price_retail_rub_formatted}}</td>
                    <td width="25%" align="right">= <b>{{ $product->order_product_price_retail_rub_sum_formatted }}</b></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <table class="action" align="center">
        <tbody>
            <tr>
                <td align="center">
                    <a href="{{$actionUrl}}" class="button button-primary" target="_blank">Перейти в личный кабинет</a>
                </td>
            </tr>
        </tbody>
    </table>
    <p>В личном кабинете Вы можете увидеть свои заказы.</p>
    @if($password)
        <p>Для входа в личный кабинет запомните присвоенный Вам пароль <b>{{$password}}</b>, логином является ваш e-mail.</p>
    @endif
    <p>Пожалуйста, при обращении к администрации сайта {{Support\H::website()}} ОБЯЗАТЕЛЬНО указывайте номер Вашего заказа - <b>{{$order->id}}</b>. Связаться с менеджером можно по телефону: {{Support\H::getPhone1()}}.</p>
    <p>Спасибо за покупку!</p>
    <p>
        С уважением,<br/>
        администрация <a href="{{route('home')}}">Интернет-магазина</a> <br/>
        E-mail: {{Support\H::getMail()}}
    </p>
@endsection

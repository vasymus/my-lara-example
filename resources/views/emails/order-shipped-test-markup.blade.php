<?php /** @var \Domain\Orders\Models\Order $order */ ?>

@extends('emails.layouts.app')

@section('content')
    <h1>Спасибо, что обратились в наш интернет-магазин</h1>
    <p>Ваш заказ номер <b>1111</b> от 12.01.2021 обрабатывается.</p>
    <p>Менеджер свяжется с Вами для уточнения способа оплаты и получения заказа.</p>
    <p>Стоимость заказа: <b>1 100 р</b>.</p>
    <p>Состав заказа:</p>
    <div class="table">
        <table>
            <tbody>
                <tr>
                    <td width="50%"><a href="#">Клён - штучный паркет</a></td>
                    <td width="25%" align="center">5 шт. x 1 100 р</td>
                    <td width="25%" align="right">= <b>5 500 р</b></td>
                </tr>
                <tr>
                    <td><a href="#">Клён - какое-то очень-очень очень-очень очень-очень очень-очень очень-очень очень-очень очень-очень очень-очень очень-очень очень-очень длинное название</a></td>
                    <td align="center">5 шт. x 1 100 р</td>
                    <td align="right">= <b>5 500 р</b></td>
                </tr>
                <tr>
                    <td><a href="#">Клён - штучный паркет</a></td>
                    <td align="center">5 шт. x 1 100 р</td>
                    <td align="right">= <b>5 500 р</b></td>
                </tr>
            </tbody>
        </table>
    </div>
    <table class="action" align="center">
        <tbody>
        <tr>
            <td align="center">
                <a href="#" class="button button-primary" target="_blank">Перейти в личный кабинет</a>
            </td>
        </tr>
        </tbody>
    </table>
    <p>В личном кабинете Вы можете увидеть свои заказы.</p>
    <p>Для входа в личный кабинет запомните присвоенный Вам пароль <b>IHFDEC</b>, логином является ваш e-mail.</p>
    <p>Пожалуйста, при обращении к администрации сайта {{Support\H::website()}} ОБЯЗАТЕЛЬНО указывайте номер Вашего заказа - <b>9491</b>. Связаться с менеджером можно по телефону: {{Support\H::getPhone1()}}.</p>
    <p>Спасибо за покупку!</p>
    <p>
        С уважением,<br/>
        администрация <a href="#">Интернет-магазина</a> <br/>
        E-mail: <a href="#">mail@market-parket.ru</a>
    </p>
@endsection

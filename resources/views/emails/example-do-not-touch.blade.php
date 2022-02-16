@extends('emails.layouts.app')

@section('content')
    <h1>Спасибо, что обратились в наш интернет-магазин</h1>
    <p>Ваш заказ номер 9491 от 12.01.2021 обрабатывается.</p>
    <p>Менеджер свяжется с Вами для уточнения способа оплаты и получения заказа.</p>
    <p>Стоимость заказа: <b>2 402 741 р.</b></p>
    <p>Состав заказа:</p>
    <div class="table">
        <table>
            <thead>
            <tr>
                <th>Laravel</th>
                <th>Table</th>
                <th>Example</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Col 2 is</td>
                <td align="center">Centerd</td>
                <td align="right">$10</td>
            </tr>
            <tr>
                <td>Col 2 is</td>
                <td align="center">Right-Aligned</td>
                <td align="right">$20</td>
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
    <p>Пожалуйста, при обращении к администрации сайта market-parket.ru ОБЯЗАТЕЛЬНО указывайте номер Вашего заказа - 9491. Связаться с менеджером можно по телефону: {{Support\H::getPhone1()}}.</p>
    <p>Спасибо за покупку!</p>
    <p>
        С уважением,<br/>
        администрация <a href="#">Интернет-магазина</a> <br/>
        E-mail: <a href="#">mail@market-parket.ru</a>
    </p>
@endsection

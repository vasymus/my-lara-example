<?php /** @var \Domain\Orders\Models\Order $order */ ?>

@extends('emails.layouts.app')

@section('content')
    <h1>Здравствуйте!</h1>
    <p>Вы получили данное письмо, поскольку на наш сайт пришёл запрос о восстановлении пароля.</p>

    <table class="action" align="center">
        <tbody>
        <tr>
            <td align="center">
                <a href="#" class="button button-primary" target="_blank">Восстановить Пароль</a>
            </td>
        </tr>
        </tbody>
    </table>
    <p>Ссылка будет активна в течение 60 минут.</p>
    <p>Если вы не запрашивали восстановление пароля, просто игнорируйте это письмо.</p>

    <p>
        С уважением,<br/>
        администрация <a href="#">Интернет-магазина</a> <br/>
        E-mail: <a href="#">mail@market-parket.ru</a>
    </p>
@endsection

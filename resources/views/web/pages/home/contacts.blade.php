@extends('web.pages.page-layout')

@section('page-content')
    <x-h1 :entity="'Производители'"/>
    <x-go-back/>

    <div class="content__white-block">
        <div class="contact-single">
            <p>
                <a href="#point">Пункт самовывоза</a>.&nbsp;Доставляем заказы в регионы России,
                Казахстана и Беларуси.
            </p>
            <p>
                Звоните: <a href="tel:+74957600518">+7 (495) 760-05-18</a>
            </p>
        </div>
        <div class="contact-single">
            <form action="#">
                <div class="form-group">
                    <div class="form-group__item">
                        <p>Пишите нам на <strong><a href="mailto:market-parket@mail.ru">market-parket@mail.ru</a></strong> или через форму:</p>
                    </div>
                    <div class="form-group__item">
                        <label>Ваше имя</label>
                        <input class="form-control" type="text" value="" name="user_name" size="60">
                    </div>
                    <div class="form-group__item">
                        <label>Электронная почта <em>*</em></label>
                        <input class="form-control" type="text" value="" name="user_email"
                               size="60">
                    </div>
                    <div class="form-group__item">
                        <label>Телефон <em>*</em></label>
                        <input class="form-control" type="text" name="user_phone" value=""
                               id="feedback_form_phone" size="60">
                    </div>
                    <div class="form-group__item">
                        <label>Сообщение <em>*</em></label>
                        <textarea class="form-control" name="MESSAGE"></textarea>
                    </div>
                    <div class="form-group__item">
                        <label>Приложить файл</label>
                        <div class="block-file">
                            <div class="bg_img">
                                <input class="form-control-file" type="file" name="file[]">
                            </div>
                        </div>
                    </div>
                    <div class="form-group__item">
                        <label>Введите код с картинки</label>
                        <div class="row-line row-line__center">
                            <input class="form-control small" type="text" name="captcha_word" size="30" maxlength="50" value="" />
                            <img src="{{asset("images//captcha.jpeg")}}" width="180" height="40" alt="CAPTCHA">
                        </div>
                    </div>
                    <div class="form-group__item">
                        <label><em>*</em> - обязательные для заполнения поля</label>
                        <input type="submit" class="btn-submit" value="Отправить вопрос">
                        <p class="form-group__text">Нажимая на кнопку "Отправить", я даю <a href="#" data-fancybox="consent-processing-personal-data" data-src="#consent-processing-personal-data">согласие на обработку своих персональных данных</a>
                        </p>
                    </div>
                </div>
            </form>

        </div>
        <div class="contact-single" id="point">
            <p><strong>Пункт выдачи оплаченных заказов:</strong></p>
            <p>Адрес: Москва, Протопоповский переулок, дом 19, строение 13, офис 14</p>
            <p>Время работы: с 10-00 по 18-00, кроме субботы и воскресения.</p>
            <p><img class="map" src="{{asset("images//map.png")}}" alt="" title=""></p>
        </div>
        <div class="contact-single">
            <p><strong>Реквизиты</strong></p>
            <table cellspacing="0" cellpadding="5">
                <tbody>
                <tr valign="top">
                    <td>
                        <u>НАЗВАНИЕ ОРГАНИЗАЦИИ</u>:
                    </td>
                    <td>
                        Общество с ограниченной ответственностью «СТП»
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <u>ИНН / КПП</u>:
                    </td>
                    <td>
                        7716673708 / 771601001
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <u>ЮРИДИЧЕСКИЙ АДРЕС</u>:
                    </td>
                    <td>
                        129337, г. Москва, ул. Палехская, д. 13-134
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <u>ФАКТИЧЕСКИЙ АДРЕС</u>:
                    </td>
                    <td>
                        г. Москва, Протоповский переулок, д. 19, стр. 13,&nbsp;офис 14
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <u>ТЕЛЕФОН</u>:
                    </td>
                    <td>
                        +7 (495) 760-05-18
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <u>РАСЧЁТНЫЙ СЧЁТ</u>:
                    </td>
                    <td>
                        40702810600280170169&nbsp;в Филиал "Центральный" Банка ВТБ (ПАО)&nbsp;г.
                        Москва<br>
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <u>БИК</u>:
                    </td>
                    <td>
                        044525411
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <u>КОРРЕСПОНДЕНТСКИЙ СЧЁТ</u>:
                    </td>
                    <td>
                        30101810145250000411
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <u>ОГРН</u>:
                    </td>
                    <td>
                        1107746852201
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <u>ОКПО</u>:
                    </td>
                    <td>
                        68863706
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <br>
                    </td>
                    <td>
                        <br>
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        &nbsp;
                    </td>
                    <td>
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <b>Реквизиты банка</b>
                    </td>
                    <td>
                        <br>
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <u>Название</u>
                    </td>
                    <td>
                        Филиал "Центральный" Банка ВТБ (ПАО)&nbsp;г. Москва<br>
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <u>БИК</u>
                    </td>
                    <td>
                        044525411
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <u>Корреспондентский счет</u>:
                    </td>
                    <td>
                        30101810145250000411&nbsp;в Отделении 1 Главного управления Центрального
                        банка Российской Федерации по Центральному федеральному округу г. Москва
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <u>Адрес</u>:
                    </td>
                    <td>
                        103055, г. Москва, ул. Тихвинская, д. 9, стр. 1
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <u>Телефон</u>
                    </td>
                    <td>
                        +7(499) 972-66-00
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <u>ИНН</u>
                    </td>
                    <td>
                        7702070139
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <u>ОКПО</u>
                    </td>
                    <td>
                        29292940
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <br>
                    </td>
                    <td>
                        <br>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

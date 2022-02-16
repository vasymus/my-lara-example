@extends('web.pages.page-layout')

@section('page-content')
    <x-h1 :entity="'Как купить'"></x-h1>

    <x-go-back/>

    <div class="content__white-block single">
        <div class="row-line steps">
            <div class="column">
                <div class="image">
                    <img src="{{asset("images//howto/img.jpg")}}" alt="" title="">
                </div>
            </div>
            <div class="column">
                <div class="image">
                    <img src="{{asset("images//howto/img1.jpg")}}" alt="" title="">
                </div>
            </div>
            <div class="column">
                <div class="image">
                    <img src="{{asset("images//howto/img2.jpg")}}" alt="" title="">
                </div>
            </div>
            <div class="column">
                <div class="image">
                    <img src="{{asset("images//howto/img3.jpg")}}" alt="" title="">
                </div>
            </div>
        </div>
        <p>
            1. Положите понравившиеся товары в "<span style="font-size: 11pt;">корзину</span>" в нужном количестве.
        </p>
        <p>
            2. Оформите и отправьте заказ.
        </p>
        <p>
            3. Менеджер обязательно свяжется с Вами для уточнения способа оплаты и доставки заказа.
        </p>
        <p>&nbsp;</p>
        <h2>Как искать товар на сайте? </h2>
        <p>Товары сгруппированы по тематическим разделам в <span style="color: #0054a5;"><b><span style="color: #ee1d24; font-size: 10pt;">КАТАЛОГ&nbsp;ТОВАРОВ.</span></b></span> (<a data-fancybox="gallery-1" href="{{asset("images//howto/picer.png")}}" data-caption="ФОТО РАЗДЕЛА"><span style="color: #0054a5;">левое&nbsp;меню</span></a>)
        </p>
        <p>
            Используйте поисковую строку сайта или обращайтесь к менеджеру по телефону. (<a data-fancybox="gallery-1" href="{{asset("images//howto/1picer.png")}}" data-caption="ФОТО ПОИСКА"><span style="color: #0054a5;">шапка сайта</span></a>)
        </p>
        <p>
            Задавайте письменные вопросы через формы
            <span style="font-size: 10pt;">
                        <a href="{{route('contacts')}}">
                            <span style="font-size: 8pt; color: #0054a5;">
                                <b>КОНТАКТЫ</b>
                            </span>
                        </a>
                    </span> и
            <span style="font-size: 8pt;">
                        <a href="{{route('ask')}}">
                            <b>
                                <span style="color: #0054a5;">ЗАДАЙТЕ ВОПРОС</span>
                            </b>
                        </a>
                    </span>
            <span style="font-size: 8pt;">
                        <b>
                            <span style="color: #0054a5;">
                                <span style="color: #0054a5;">.</span>
                            </span>
                        </b>
                    </span>
            (<a data-fancybox="gallery-1" href="{{asset("images//howto/2picer.png")}}" data-caption="ФОТО КОНТАКТОВ"><span style="color: #0054a5;">верхнее меню</span></a>)
        </p>
        <p>
            Просмотренные товары останутся в блоке «<span style="color: #0054a5;"><b><a data-fancybox="gallery-1" href="{{asset("images//howto/b04119ad376b9c6ee92e69700414ef17.png")}}" data-caption="ФОТО ВЫ СМОТРЕЛИ"><span style="color: #0054a5;">Вы смотрели</span></a></b></span>», можно быстро к ним вернуться.
        </p>
        <p>
            Понравившиеся товары можно поместить в раздел «<span style="color: #0054a5;"><b><a data-fancybox="gallery-1" href="{{asset("images//howto/9e76391148057415491c60a1e12c4c87.png")}}" data-caption="ФОТО ОТЛОЖЕНО"><span style="color: #0054a5;">Отложенные товары</span></a></b></span>».
        </p>
        <p>
            Для совершения покупки перейдите на страницу выбранного товара кнопкой <span style="background-color: #464646; color: #ffffff; font-size: 10pt;"><b>&nbsp;&nbsp;купить &nbsp;</b></span>. (<a data-fancybox="gallery-1" href="{{asset("images//howto/3picer.png")}}" data-caption="ФОТО ПЕРЕЙТИ В ТОВАР"><span style="color: #0054a5;">смотреть</span></a>)
        </p>
        <p>&nbsp;</p>
        <h2>Как положить товар в корзину?</h2>
        <p>
            1. Перейдите на страницу товара, и выберите нужный вариант. Фотографию товара можно увеличить. (<a data-fancybox="gallery-1" href="{{asset("images//howto/4picer.png")}}" data-caption="ФОТО ТОВАРА"><span style="color: #0054a5;">смотреть</span></a>)
        </p>
        <p>
        </p>
        <p>
            2. Укажите нужное количество товара и нажмите кнопку <b><span style="font-size: 10pt; background-color: #ee1d24; color: #ffffff;">&nbsp;&nbsp;</span></b><span style="color: #0054a5;"><b><span style="font-size: 10pt; background-color: #ee1d24; color: #ffffff;">В корзину &nbsp;</span></b></span>.
            (<a data-fancybox="gallery-1" href="{{asset("images//howto/5picer.png")}}" data-caption="ФОТО ПОЛОЖИТЬ В КОРЗИНУ"><span style="color: #0054a5;">смотреть</span></a>)
        </p>
        <p>
            3. Закончив покупки, перейдите на страницу&nbsp;«<span style="font-size: 11pt;">Корзина</span>» для проверки и оформления заказа.
        </p>
        <p>
            <span style="color: #ff0000;">*</span> В корзине можно поменять количество товара.
        </p>
        <p>&nbsp;</p>
        <h2>
            Как оформить заказ? </h2>
        <p>
            1. Перейдите на страницу&nbsp;<span
                style="color: #262626; font-size: 12pt;">«</span><span style="color: #262626;"><span
                    style="font-size: 11pt;">Корзина</span></span>».
        </p>
        <p>
            2. Заполните три обязательных поля:
        </p>
        <p>
            <span style="color: #ff0000;">*</span> &nbsp;Имя&nbsp;
        </p>
        <p>
            <span style="color: #ff0000;">*</span> &nbsp;Email&nbsp;
        </p>
        <p>
            <span style="color: #ff0000;">*</span> &nbsp;Номер телефона&nbsp;
        </p>
        <p>
            3. а) проверьте перечень товаров и их количество.
        </p>
        <p>
            &nbsp; &nbsp; б) в&nbsp;поле для комментариев укажите адрес доставки и способ оплаты.
        </p>
        <p>
            &nbsp; &nbsp; в) для выставления счета по безналу, прикрепите файл с реквизитами
            организации.
        </p>
        <p>
            4. По окончании нажмите кнопку <span style="color: #ee1d24;"><b><span style="font-size: 11pt; background-color: #f7941d; color: #262626;">&nbsp; Отправить заказ &nbsp;</span></b></span>.
            (<a data-fancybox="gallery-1" href="{{asset("images//howto/6picer.png")}}" data-caption="ФОТО КОРЗИНА"><span style="color: #0054a5;">смотреть</span></a>)
        </p>
        <p>
            Менеджер обязательно свяжется с вами для согласования&nbsp;<span style="color: #0072bc;"><a href="{{route('delivery')}}"><span style="color: #0054a5;">оплаты и доставки</span></a>&nbsp;<span style="color: #000000;">заказа</span></span>.
        </p>
        <p>
            Способы оплаты заказа:<br>
        </p>
        <p>
            -&nbsp;банковской картой
        </p>
        <p>
            -&nbsp;наличными при получении
        </p>
        <p>
            -&nbsp;квитанция&nbsp;Сбербанка
        </p>
        <p>
            -&nbsp;с расчетного счета
        </p>
        <p>
            Способы получение заказа:<br>
        </p>
        <p>
            - <a href="{{route('contacts')}}"><span style="color: #0054a5;">самовывоз</span></a>
        <p>
            -&nbsp;доставка
        </p>
        <p>
            -&nbsp;отправка транспортной компанией в регионы России, Казахстана и Беларуси
        </p>
    </div>
@endsection

@extends('web.pages.page-layout')

@section('page-content')
    <x-h1 :entity="'Оплата и доставка'"></x-h1>

    <x-go-back/>

    <div class="content__white-block single">
        <h2>Оплата заказа</h2>
        <p>Оформленный заказ автоматически резервируется на складе до поступления оплаты:</p>
        <ul>
            <li>на 1 сутки, если вы выбрали оплату наличными или банковской картой</li>
            <li>на 3 рабочих дня,&nbsp;в случае оплаты через расчетный счет или по квитанции
                Сбербанка
            </li>
        </ul>
        <p>Если вы не оплатили&nbsp;вовремя,&nbsp;свяжитесь с менеджером, и он выставит счет
            заново.</p>
        <p>&nbsp;</p>
        <h2>Способы оплаты</h2>
        <p>
            <strong style="color: #0054a5; font-size: 11pt;">Оплата наличными</strong>&nbsp;- курьеру при доставке (только Москва и Московская область).
        </p>
        <p><strong style="color: #0054a5; font-size: 11pt;">Оплата банковской картой</strong>&nbsp;-&nbsp;<b>онлайн</b>. Это безопасно&nbsp;- вас переадресуют на <a href="http://rfibank.ru"><span style="color: #0054a5;">сайт банка</span></a>,&nbsp;где оплата пройдёт по зашифрованному протоколу.&nbsp;Мы не имеем доступа к данным вашей карты.</p>
        <p><strong style="color: #0054a5; font-size: 11pt;">Оплату по квитанции</strong> &nbsp;можно осуществить в любом отделении Сбербанка или <b>онлайн&nbsp;</b>из Вашего личного кабинета в Сбербанке. За услугу по переводу денег банк возьмет комиссию&nbsp;согласно действующих&nbsp;тарифов. Перечисление денег занимает до&nbsp;3-х рабочих дней.</p>
        <p><strong><span style="color: #0054a5; font-size: 11pt;">Оплата с расчетного счета</span></strong>. <br>
            После оформления заказа менеджер вышлет&nbsp;на ваш е-mail&nbsp;счет для оплаты.
            Оплаченный заказ будет доставлен&nbsp;по указанному адресу со всеми документами (счет и&nbsp;товарная
            накладная).</p>
        <p>Оплаченный заказ&nbsp;можно получить доставкой или забрать в&nbsp;<a href="{{route("contacts")}}">пункте
                самовывоза</a>.</p>
        <p>&nbsp;</p>
        <h2>Время и стоимость&nbsp;доставки</h2>
        <p>
            Время&nbsp;и стоимость&nbsp;доставки по Москве и Московской области&nbsp;согласовываются
            с менеджером, который обязательно свяжется с Вами после оформления заказа. Стоимость
            доставки зависит от:
        </p>
        <ul>
            <li>габаритов груза</li>
            <li>адреса доставки</li>
            <li>суммы заказа</li>
        </ul>
        <p>
            В регионы России, Казахстана и Беларуси доставка осуществляется с привлечением
            транспортной компании.
        </p>
        <p>
            Доставка до терминала транспортной компании выполняется ежедневно <b>с 10:00 до
                20:00</b>, кроме субботы и&nbsp;воскресенья.
        </p>
        <p>
            Дата&nbsp;доставки зависит от времени размещения заказа -&nbsp;если заказ подтвержден&nbsp;или
            оплачен&nbsp;<b>до 12:00</b>, то товар может быть доставлен в день оформления заказа или
            на следующий <b>рабочий</b> день.
        </p>
        <p>&nbsp;</p>
        <h2>Правила доставки</h2>
        <p>
            <span style="color: #9d0a0f;">Доставка по Москве и ближнему Подмосковью</span>
            производится транспортом интернет-магазина.&nbsp;
        </p>
        <p>
            &nbsp;&nbsp; -&nbsp;доставка осуществляется&nbsp;до подъезда, и не включает подъём на
            этаж.&nbsp;
        </p>
        <p>
            &nbsp;&nbsp; -&nbsp;оформление документов для въезда на охраняемую территорию&nbsp;организует
            принимающая сторона.
        </p>
        <p>
            <span style="color: #9d0a0f;">Доставка в регионы России, Казахстана и Беларуси</span>&nbsp;осуществляется
            транспортными компаниями&nbsp;«ПЭК», «Деловые&nbsp;линии», «ЖелДорЭкспедиция». Иные
            компании согласовываются дополнительно. Право собственности переходит Покупателю в
            момент передачи заказа на склад транспортной компании, что подтверждается накладной.
            Проверяйте заказ при получении, интернет-магазин не несет ответственность по
            обязательствам транспортной компании.
        </p>
        <p>
            &nbsp; -&nbsp;доставка до терминала транспортной компании в Москве производится силами
            интернет-магазина <b>бесплатно</b>
        </p>
        <p>
            <b>&nbsp; </b>-&nbsp;услуги транспортной компании вы оплачиваете&nbsp;при получении
            груза, по расценкам транспортной компании<b><br>
            </b>
        </p>
        <p>
            &nbsp; -&nbsp;груз оформляется по категории&nbsp;"в&nbsp;жесткой упаковке"
        </p>
        <p>
            &nbsp; -&nbsp;страхование груза на время транспортировки&nbsp;производится по
            согласованию с заказчиком
        </p>
        <p>
            &nbsp; -&nbsp;оформление "тёплой доставки" предварительно согласовывается с заказчиком
            (для водных лаков и клеев)
        </p>
        <p>
            &nbsp; -&nbsp;после оформления, вам на e-mail высылается экспедиторская накладная&nbsp;
            &nbsp;
        </p>
        <p>
            <b>У вас остались вопросы? Получите ответы по телефону +7(495) 760-05-18</b><br>
        </p>
    </div>
@endsection
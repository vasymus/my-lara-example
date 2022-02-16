<?php
/**
 * @see \App\View\Composers\ProfileComposer::compose()
 * @var int $cartCount
 * @var int $asideCount
 */
?>
<footer class="footer-top">
    <div class="container hidden-md hidden-lg">
        <div class="row-line row-line__between">
            <div class="column-mobile"><a href="{{route("contacts")}}">Контакты</a></div>
            <div class="column-mobile"><a href="{{route("gallery.items.index")}}">Фотогалерея</a> / <a href="{{route("faq.index")}}">Вопрос-ответ</a></div>
        </div>
    </div>
    <div class="container hidden-sm hidden-xs">
        <div class="row-line">
            <div class="column">
                <h4>Штучный паркет</h4>
                <ul class="menu-list-links">
                    <li><a href="/articles/shtuchnyy-parket/">Штучный паркет - что это?</a></li>
                    <li><a href="{{route("services.show", "ukladka-shtuchnogo-parketa")}}">Укладка паркета</a></li>
                    <li><a href="{{route("services.show", "tsiklevka-parketa")}}">Шлифовка штучного паркета</a></li>
                    <li><a href="{{route("services.show", "tonirovanie-parketa")}}">Тонирование штучного паркета</a></li>
                    <li><a href="/articles/shtuchnyy-parket/lak-ili-maslo/">Паркет под лаком или маслом</a></li>
                    <li><a href="/articles/shtuchnyy-parket/vidy-ukladok/">Варианты укладки паркета</a></li>
                    <li><a href="/articles/shtuchnyy-parket/porody-dereva/">Породы дерева</a></li>
                </ul>
            </div>
            <div class="column">
                <h4>Массивная доска</h4>
                <ul class="menu-list-links">
                    <li><a href="/articles/massivnaya-doska/">Массивная доска – 5 параметров выбора!</a></li>
                    <li><a href="{{route("services.show", "ukladka-massivnoy-doski")}}">Укладка массивной доски</a></li>
                    <li><a href="{{route("services.show", "tsiklevka-parketa")}}">Шлифовка массивной доски</a></li>
                    <li><a href="/articles/massivnaya-doska/lak-ili-maslo-mass/">Массив под лаком или маслом</a></li>
                    <li><a href="{{route("services.show", "tonirovanie-parketa")}}">Тонировка массивной доски</a></li>
                    <li><a href="/articles/massivnaya-doska/porody-dereva-mass/">Породы древесины массивной доски</a>
                    </li>
                    <li><a href="/ukhod-za-parketom/">Уход за паркетом</a></li>
                </ul>
            </div>
            <div class="column">
                <h4>Паркетная доска</h4>
                <ul class="menu-list-links">
                    <li><a href="/articles/parketnaya-doska/">Инженерный паркет и паркетная доска - как они есть!</a>
                    </li>
                    <li><a href="{{route("services.show", "ukladka-parketnoy-doski")}}">Укладка паркетной доски</a></li>
                    <li><a href="{{route("services.show", "tsiklevka-parketa")}}">Шлифовка паркетной доски</a></li>
                    <li><a href="{{route("services.show", "tonirovanie-parketa")}}">Колеровка паркетной доски</a></li>
                    <li><a href="/articles/parketnaya-doska/lak-ili-maslo-parket/">Лак или масло?</a></li>
                    <li><a href="/articles/parketnaya-doska/porody-dereva-parket/">Паркетная доска - породы дерева</a>
                    </li>
                </ul>
            </div>
            <div class="column">
                <h4>Ламинат</h4>
                <ul class="menu-list-links">
                    <li><a href="/articles/laminat/">Ламинат - что это?</a></li>
                    <li><a href="{{route("services.show", "ukladka-laminata")}}">Укладка ламината</a></li>
                    <li><a href="/articles/laminat/materialy-dlya-ukladki-laminat/">Материалы для укладки</a></li>
                    <li><a href="/articles/laminat/ukhod-za-laminatom/">Уход за ламинатом</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<footer class="footer">
    <div class="container">
        <div class="search-block">
            <form action="#">
                <div class="search-field">
                    <input type="text" value="" placeholder="Что вы ищете?">
                    <input name="s" type="submit" value="Поиск">
                </div>
            </form>
            <div class="suggestion">Например: <span>Масло с твердым воском Stauf Hardwaxoil Matt</span></div>
        </div>
        <div class="row-line info-lists">
            <div class="column">
                <h3 class="title-footer"><span>ИНФОРМАЦИЯ</span></h3>
                <ul class="footer-menu">
                    <li><a href="{{route('howto')}}"><i class="fa fa-angle-right" aria-hidden="true"></i>Как купить</a></li>
                    <li><a href="{{route('delivery')}}"><i class="fa fa-angle-right" aria-hidden="true"></i>Оплата и доставка</a></li>
                    <li><a href="{{route('return')}}"><i class="fa fa-angle-right" aria-hidden="true"></i>Возврат товара</a></li>
                    <li><a href="{{route('contacts')}}"><i class="fa fa-angle-right" aria-hidden="true"></i>Контакты</a></li>
                    <li><a href="{{route('ask')}}"><i class="fa fa-angle-right" aria-hidden="true"></i>Задайте вопрос</a></li>
                </ul>
            </div>
            <div class="column">
                <h3 class="title-footer"><span>ПОЛЕЗНОЕ</span></h3>
                <ul class="footer-menu">
                    <li><a href="{{route('viewed')}}"><i class="fa fa-angle-right" aria-hidden="true"></i>Вы смотрели ({{$viewedCount}})</a></li>
                    <li><a href="{{route('aside')}}"><i class="fa fa-angle-right" aria-hidden="true"></i>Отложенные товары (<span class="js-aside-items-count">{{$asideCount}}</span>)</a></li>
                    <li>
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        <a href="{{route('cart.show')}}">Ваша корзина (<span class="js-add-to-cart-count">{{$cartCount}}</span>)</a>
                    </li>
                    <li><a href="{{route('profile')}}"><i class="fa fa-angle-right" aria-hidden="true"></i>Мои заказы</a></li>
                    <li><a href="{{route('brands.index')}}"><i class="fa fa-angle-right" aria-hidden="true"></i>Производители</a></li>
                </ul>
            </div>
            <div class="column">
                <h3 class="title-footer"><span>КОНТАКТЫ</span></h3>
                <ul class="footer-address">
                    <li class="contact-address">
                        <a href="{{route('contacts')}}">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            Москва, Протопоповский переулок,<br> дом 19, строение 13, офис 14
                        </a>
                    </li>
                    <li>
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        {{Support\H::getPhone1()}}
                    </li>
                    <li>
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <a href="tel:+79153639363">+7 (915) 363 9 363 консультация</a>
                    </li>
                    <li>
                        <i class="fa fa-at" aria-hidden="true"></i>
                        {{Support\H::getMail()}}
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer-info-site">
            <p class="footer-info-site__text">Данный сайт носит информационный характер и не является публичной офертой, определяемой положениями Статьи 437 (2) Гражданского кодекса Российской Федерации. Для получения подробной информации обращайтесь к менеджерам через форму «контакты» или по телефону: <a href="tel:+74953638799">+7 (495) 363 87 99</a>.</p>
        </div>
        <div class="credit-cards">
            <img src="{{asset("images//Visa.png")}}" width="55" height="34">
            <img src="{{asset("images//MasterCard.png")}}" width="55" height="34">
            <img src="{{asset("images//Maestro.png")}}" width="55" height="34">
            <img src="{{asset("images//Maestro1.png")}}" width="55" height="34">
        </div>
    </div>
</footer>
<footer class="footer-copy">
    <div class="container">
        <p>Copyright © 2020 PARKET-LUX – продажа паркета, лаков, клеев</p>
    </div>
</footer>

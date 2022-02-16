<header class="header fixed-top-centered">
    <div class="container">
        <div class="row-line">
            <div class="header-column">
                <a class="logo" href="{{route("home")}}">
                    <img alt="Parket Lux" title="Parket Lux" src="{{asset("images//logo.svg")}}">
                </a>
                <a class="toggle @yield('toggle-class')" href="#"></a>
            </div>
            <div class="header-search-block hidden-sm hidden-xs">
                <div class="search-block">
                    <form action="#">
                        <div class="search-field">
                            <input type="text" id="sfrm" name="q" value="" placeholder="Что вы ищете?">
                            <input name="s" type="submit" value="Поиск">
                        </div>
                    </form>
                    <div class="suggestion">Например: <a id="ssugg">Ремонт паркета</a></div>
                </div>
            </div>
            <div class="header__icon-mobile">
                <a href="{{route('cart.show')}}" class="basket js-add-to-cart-tooltip">
                    <img src="{{asset("images//cart.svg")}}" alt="" title="">
                    <span class="count js-add-to-cart-count js-add-to-cart-animate cart-items-count">{{$cartCount}}</span>
                </a>
                <a href="tel:+74957600518" class="phone-icon">
                    <img src="{{asset("images//phone.svg")}}" alt="" title="">
                </a>
            </div>
            <div class="contacts-column">
                <ul class="contacts-list">
                    <li>
                        <a class="phone" href="tel:+74953638799">+7 (495) 363 87 99</a>
                    </li>
                    <li>
                        <a class="phone" href="tel:+79153639363">+7 (915) 363 9 363</a>
                    </li>
                    <li class="text">
                        каждый день с 9:00 до 21:00
                    </li>
                    <li>
                        <a data-fancybox="contact-with-technologist" data-src="#contact-with-technologist" href="#" class="link">Связаться с технологом</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="menu">
            <ul>
                <li><a href="{{route("howto")}}">Как купить</a></li>
                <li><a href="{{route("delivery")}}">ОПЛАТА И ДОСТАВКА</a></li>
                <li><a href="{{route("contacts")}}">Контакты</a></li>
                <li><a href="{{route("ask")}}">Задайте вопрос</a></li>
                <li><a href="{{route("brands.index")}}">Производители</a></li>
                <li><a href="{{route("videos.index")}}">Видео</a></li>
                <li><a href="{{route("gallery.items.index")}}">Фото</a></li>
            </ul>
        </div>
    </div>
</header>


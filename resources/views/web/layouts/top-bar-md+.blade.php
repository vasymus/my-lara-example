<?php
/**
 * @see \App\View\Composers\ProfileComposer::compose()
 * @var int $cartCount
 */
?>
<div class="top-bar hidden-xs">
    <div class="container">
        <div class="row-line">
            <div class="column-back">
                <a href="#" class="top-bar__back js-back">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                         width="16" height="16" viewBox="0 0 16 16">
                        <path fill="#fff"
                              d="M6.293 13.707l-5-5c-0.391-0.39-0.391-1.024 0-1.414l5-5c0.391-0.391 1.024-0.391 1.414 0s0.391 1.024 0 1.414l-3.293 3.293h9.586c0.552 0 1 0.448 1 1s-0.448 1-1 1h-9.586l3.293 3.293c0.195 0.195 0.293 0.451 0.293 0.707s-0.098 0.512-0.293 0.707c-0.391 0.391-1.024 0.391-1.414 0z"></path>
                    </svg>
                    <span class="top-bar__welcome">Назад</span>
                </a>
            </div>
            <div class="column row-line row-line__between">
                <div class="column-left row-line row-line__between">
                    @auth('admin') <a href="{{route('admin.home')}}" class="top-bar__link">Админ</a> @endauth
                    <a href="{{route('viewed')}}" class="top-bar__link">Вы смотрели</a>
                    <a href="{{route('contacts')}}" class="top-bar__link">Контакты</a>
                    <a href="tel:74953638799" class="top-bar__link">(495) 363 87 99</a>
                    <a href="tel:79153639363" class="top-bar__link">(915) 363 9 363</a>
                </div>
                <div class="column-right row-line row-line__between">
                    <a href="{{route('cart.show')}}" class="top-bar__cart js-cart js-add-to-cart-tooltip">
                        Корзина <span class="js-add-to-cart-count js-add-to-cart-animate top-bar__count">{{$cartCount}}</span>
                    </a>
                    @if(\Support\H::userOrAdmin()->is_anonymous2)
                        <a href="{{route("login")}}" class="top-bar__enter">Вход</a>
                    @else
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="top-bar__enter">Выход</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

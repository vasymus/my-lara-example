<?php
/**
 * @see \App\View\Composers\ProfileComposer::compose()
 * @var int $asideCount
 * */
?>
<div class="sidebar-left js-sticky-sidebar">
    <div class="inner-wrapper-sticky js-inner-wrapper-sticky">
        <div class="sidebar-left__inner">
            <x-sidebar-menu-services/>

            <x-sidebar-menu-materials/>

            <!--<div class="sidebar-payment">-->
            <!--<div class="sidebar-payment__title">Любые способы оплаты</div>-->
            <!--<div class="row-line row-line__between">-->
        <!--<div class="sidebar-payment__column"><img src="{{asset("images//wallet.png")}}" alt=""></div>-->
        <!--<div class="sidebar-payment__column"><img src="{{asset("images//credit-cards.png")}}" alt=""></div>-->
        <!--<div class="sidebar-payment__column"><img src="{{asset("images//bank.png")}}" alt=""></div>-->
            <!--</div>-->
            <!--</div>-->

            <x-sidebar-menu-cart/>

            <div class="sidebar-left__fav">
                <a href="{{route('aside')}}" class="sidebar-left__fav-link">Отложенные товары</a>
                (<span class="sidebar-left__fav-count js-aside-items-count">{{$asideCount}}</span>)
            </div>


            <x-sidebar-menu-viewed/>

            <ul class="sidebar-list-block">
                <li class="sidebar-list-block__item">
                    <p class="sidebar-list-block__text">
                        <img alt="новинка" src="{{asset('images//delivery_car.gif')}}" align="left">
                        <span>Доставляем интернет заказы в регионы России</span>
                    </p>
                </li>
                <li class="sidebar-list-block__item">
                    <p class="sidebar-list-block__text">
                        <img alt="Оплата заказа" src="{{asset('images//pay_digital.gif')}}" align="left">
                        <span>Вы можете оплатить заказ курьеру наличными или через банк.</span>
                    </p>
                </li>
            </ul>

            <x-sidebar-faq/>
        </div>
    </div>
</div>

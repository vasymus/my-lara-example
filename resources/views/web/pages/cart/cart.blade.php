@extends('web.pages.page-layout')

@section('page-content')
    <x-h1 :entity="'Моя корзина'"></x-h1>
    <div class="block-back-page row-line row-line__right">
        <div class="column-back">
            <a href="#" class="js-back">
                <img src="../images/backarow.svg" width="97" alt="">
            </a>
        </div>
    </div>
    <div class="content__white-block cart form-group">
        <form action="{{route("cart.checkout")}}" method="POST" class="form-group" enctype="multipart/form-data" id="form-order">
            @csrf
            <div class="form-group__item">
                <label for="name">Имя: <span>*</span></label>
                <input type="text" class="form-control js-save-input" id="name" name="name" value="{{old("name") ?? \Support\H::userOrAdmin()->name ?? null}}"/>
                @if($errors->has("name"))
                    <div>
                        <span style="color:red">{{$errors->first("name")}}</span>
                    </div>
                @endif
            </div>

            <div class="form-group__item">
                <label for="email">E-mail: <span>*</span></label>
                <input type="text" class="form-control js-save-input" id="email" name="email" value="{{old("email") ?? \Support\H::userOrAdmin()->email ?? null}}"/>
                @if($errors->has("email"))
                    <div>
                        <span style="color:red">{{$errors->first("email")}}</span>
                    </div>
                @endif
            </div>
            <div class="form-group__item">
                <label for="phone">Телефон: <span>*</span></label>
                <div class="row-line row-line__center">
                    <span class="phone-t">+7</span>
                    <input class="form-control small js-save-input" type="text" id="phone" name="phone" value="{{old("phone") ?? \Support\H::userOrAdmin()->phone ?? null}}"/>
                </div>
                @if($errors->has("phone"))
                    <div>
                        <span style="color:red">{{$errors->first("phone")}}</span>
                    </div>
                @endif
            </div>
        </form>
        <div class="cart-block">
            <h4 class="cart__title">Проверьте ваш заказ:</h4>
            @if(count($cartProducts))
                <table class="cart__table">
                    <thead>
                        <tr>
                            <th>Наименование</th>
                            <th>Цена</th>
                            <th>Ед.</th>
                            <th>Количество</th>
                            <th>Стоимость</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartProducts as $cartProduct)
                        <?php /** @var \Domain\Products\Models\Product\Product $cartProduct */ ?>
                        <tr class="js-cart-row {{ ($cartProduct->cart_product->deleted_at ?? null) !== null ? "deleted-row" : "" }}" data-id="{{$cartProduct->id}}">
                            <td>
                                <div class="row-line row-line__center">
                                    <img src="{{$cartProduct->main_image_xs_thumb_url ?: $cartProduct->parent->main_image_xs_thumb_url}}" alt="" class="cart__image" />
                                    <a href="{{$cartProduct->web_route}}" class="cart__name-product">{!! $cartProduct->name !!}</a>
                                </div>
                            </td>
                            <td>
                                {{$cartProduct->price_retail_rub_formatted}}
                            </td>
                            <td>
                                {{$cartProduct->unit}}
                            </td>
                            <td class="count-td">
                                <div class="js-cart-column-count-part-normal" @if(($cartProduct->cart_product->deleted_at ?? null) !== null) style="display: none;" @endif data-id="{{$cartProduct->id}}">
                                    <button type="button" class="js-cart-decrement" data-id="{{$cartProduct->id}}">-</button>
                                    <input type="text" value="{{$cartProduct->cart_product->count ?? 1}}" class="js-input-hide-on-focus js-add-to-cart-instant-input js-add-to-cart-input-count-{{$cartProduct->id}}" data-id="{{$cartProduct->id}}" />
                                    <button type="button" class="js-cart-increment" data-id="{{$cartProduct->id}}">+</button>
                                </div>
                                <div class="js-cart-column-count-part-deleted" @if(($cartProduct->cart_product->deleted_at ?? null) === null) style="display: none;" @endif data-id="{{$cartProduct->id}}">
                                    <button type="button" class="js-cart-restore" data-id="{{$cartProduct->id}}">Вернуть</button>
                                    <button type="button" class="js-cart-destroy" data-id="{{$cartProduct->id}}">Удалить</button>
                                </div>
                            </td>
                            <td>
                                <span class="js-cart-item-sum-formatted" data-id="{{$cartProduct->id}}">{{ \Support\H::priceRubFormatted(($cartProduct->cart_product->count ?? 1) * $cartProduct->price_retail_rub) }}</span>
                            </td>
                            <td>
                                <a href="#" class="js-cart-delete" data-id="{{$cartProduct->id}}" @if(($cartProduct->cart_product->deleted_at ?? null) !== null) style="display: none;" @endif>&nbsp;</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="basket-mobile basket-mob">
                @foreach($cartProducts as $cartProduct)
                    <div class="basket-mobile__product-block js-cart-row {{ ($cartProduct->cart_product->deleted_at ?? null) !== null ? "deleted-row" : "" }}" data-id="{{$cartProduct->id}}">
                        <div class="row-line">
                            <div class="basket-mobile__photo">
                                <img src="{{$cartProduct->main_image_sm_thumb_url ?: $cartProduct->parent->main_image_sm_thumb_url}}" alt="" class="cart__image" />
                            </div>
                            <div class="basket-mobile__text">
                                <p>{!! $cartProduct->name !!}</p>
                                <div class="row-basket">
                                    <span class="text-large">{{$cartProduct->price_retail_rub_formatted}} / {{$cartProduct->unit}}.</span>
                                    <a href="#" class="js-cart-delete" data-id="{{$cartProduct->id}}" @if(($cartProduct->cart_product->deleted_at ?? null) !== null) style="display: none;" @endif>&nbsp;</a>
                                </div>
                            </div>
                        </div>
                        <div class="row-line row-line__right">
                            <div class="basket-mobile__blocker-gree">
                                <div class="basket-mobile__cost-basket">
                                    <span class="js-cart-item-sum-formatted" data-id="{{$cartProduct->id}}">{{ \Support\H::priceRubFormatted(($cartProduct->cart_product->count ?? 1) * $cartProduct->price_retail_rub) }}</span>
                                </div>
                                <div class="basket-mobile__count-basket">
                                    <div class="js-cart-column-count-part-normal" @if(($cartProduct->cart_product->deleted_at ?? null) !== null) style="display: none;" @endif data-id="{{$cartProduct->id}}">
                                        <button type="button" class="js-cart-decrement" data-id="{{$cartProduct->id}}">-</button>
                                        <input type="text" value="{{$cartProduct->cart_product->count ?? 1}}" class="js-input-hide-on-focus js-add-to-cart-instant-input js-add-to-cart-input-count-{{$cartProduct->id}}" data-id="{{$cartProduct->id}}" />
                                        <button type="button" class="js-cart-increment" data-id="{{$cartProduct->id}}">+</button>
                                    </div>
                                </div>
                                <div class="js-cart-column-count-part-deleted" @if(($cartProduct->cart_product->deleted_at ?? null) === null) style="display: none;" @endif data-id="{{$cartProduct->id}}">
                                    <button type="button" class="js-cart-restore" data-id="{{$cartProduct->id}}">Вернуть</button>
                                    <button type="button" class="js-cart-destroy" data-id="{{$cartProduct->id}}">Удалить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
                <div class="cart__items">
                    <span>Итого: <strong class="js-cart-total-sum-formatted">{{$cartProducts->reduce(function($acc, \Domain\Products\Models\Product\Product $item) { return $acc += ($item->price_retail_rub * ($item->cart_product->count ?? 1)); }, 0)}} р</strong></span>
                </div>
            @else
                <p>У вас пустая корзина.</p>
            @endif
        </div>
        <div class="cart__text-ar">
            <label for="comment">Вы можете оставить комментарий:</label>
            <textarea class="js-save-input" name="comment" id="comment" form="form-order" placeholder="Адрес доставки или самовывоз. Удобный способ оплаты.">{{old("comment")}}</textarea>
            @if($errors->has("comment"))
                <div>
                    <span style="color:red">{{$errors->first("comment")}}</span>
                </div>
            @endif
        </div>
        <div class="row-line center">
            <div class="column">
                <label for="attachment">Вы можете прикрепить файл:</label>
                <div class="block-file">
                    <div class="bg_img">
                        <input form="form-order" type="file" id="attachment" name="attachment[]" multiple />
                    </div>
                </div>
                @if($errors->has("attachment.*"))
                    <div>
                        <span style="color:red">{{$errors->first("attachment.*")}}</span>
                    </div>
                @endif
            </div>
            <div class="column">
                <button class="btn-submit js-clear-all-saved-inputs" type="submit" form="form-order">Отправить заказ</button>
            </div>
        </div>
        @if($errors->has("cart"))
            <div>
                <span style="color:red">{{$errors->first("cart")}}</span>
            </div>
        @endif
        @if(session()->has('cart-error'))
            <div>
                <span style="color:red">{{session()->get('cart-error')}}</span>
            </div>
        @endif
        <div class="cart__items">
            <p class="sec-data-politics-p">Нажимая на кнопку "Отправить заказ", я даю <a href="#" data-fancybox="consent-processing-personal-data" data-src="#consent-processing-personal-data">согласие на обработку своих персональных данных</a></p>
        </div>
    </div>
@endsection

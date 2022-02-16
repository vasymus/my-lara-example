<?php /** @var \Illuminate\Pagination\LengthAwarePaginator $products */ ?>

@extends('web.pages.page-layout')

@section('page-content')
    <x-h1 :entity="'Вы смотрели'"></x-h1>
    <a href="#" class="js-back">Вернуться</a>

    @if(count($products))

    {{ $products->onEachSide(1)->links('web.pagination.default') }}

    @include("web.pages.products.products-list", compact("products"))

    {{ $products->onEachSide(1)->links('web.pagination.default') }}
    @else
        <p>У вас нет просмотренных товаров</p>
    @endif
@endsection

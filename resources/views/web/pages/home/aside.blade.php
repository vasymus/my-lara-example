<?php /** @var \Illuminate\Database\Eloquent\Collection $products */ ?>

@extends('web.pages.page-layout')

@section('page-content-wrapper-class', 'js-page-content-wrapper-aside')

@section('page-content')
    <x-h1 :entity="'Отложенные товары'"></x-h1>
    <a href="#" class="js-back">Вернуться</a>

    @if(count($products))
        @include("web.pages.products.products-list", compact("products"))
    @else
        <p>У вас нет отложенных товаров</p>
    @endif

@endsection

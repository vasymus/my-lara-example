<?php /** @var \Illuminate\Pagination\LengthAwarePaginator $orders */ ?>

@extends('web.pages.page-layout')

@section('page-content')
    <x-h1 :entity="'Мои заказы'"></x-h1>

    @if(count($orders))

        {{ $orders->onEachSide(1)->links('web.pagination.default') }}

        @include("web.pages.orders.orders-list", compact("orders"))

        {{ $orders->onEachSide(1)->links('web.pagination.default') }}
    @else
        <p>У вас не было заказов.</p>
    @endif
@endsection

@extends('web.pages.page-products-layout')

@section('page-products-content')
    <x-h1 :entity="$entity"></x-h1>
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"></x-breadcrumbs>
    <button class="btn-sort js-sidebar-slide-toggle-2">Сортировать</button>

    <?php /** @var \Illuminate\Pagination\LengthAwarePaginator $products */ ?>
    {{ $products->onEachSide(1)->links('web.pagination.default') }}

    @include("web.pages.products.products-list", compact("products"))

    {{ $products->onEachSide(1)->links('web.pagination.default') }}
@endsection

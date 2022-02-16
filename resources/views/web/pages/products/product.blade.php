@extends('web.pages.page-product-layout')

@section('page-content')
    <?php /** @var \Domain\Products\Models\Product\Product $product */ ?>
    <?php /** @var \Support\Breadcrumbs\BreadcrumbDTO[] $breadcrumbs */ ?>
    <x-h1 :entity="$product"></x-h1>

    <div class="row-line product__breadcrumbs-header">
        <div class="column">
            <x-breadcrumbs :breadcrumbs="$breadcrumbs"></x-breadcrumbs>
        </div>
        <div class="column">
            <a href="{{\Illuminate\Support\Arr::last($breadcrumbs)->url ?? null}}" class="btn-back"></a>
        </div>
    </div>
    <x-product :product="$product" :asideIds="$asideIds"></x-product>
@endsection

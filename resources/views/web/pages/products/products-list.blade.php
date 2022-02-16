<?php /** @var \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection $products */ ?>
@php
$perPage = $products instanceof \Illuminate\Pagination\LengthAwarePaginator ? $products->perPage() : null;
$currentPage = $products instanceof \Illuminate\Pagination\LengthAwarePaginator ? $products->currentPage() : null;
@endphp
@foreach($products as $product)
    <?php /** @var \Domain\Products\Models\Product\Product $product */ ?>
    @php($index = $loop->index)
    <x-product-item :product="$product" :index="$index" :perPage="$perPage" :currentPage="$currentPage" :asideIds="$asideIds" />
@endforeach

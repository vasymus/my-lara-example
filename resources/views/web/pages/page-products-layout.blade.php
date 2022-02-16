@extends('web.layouts.app')

@section('title')
    {{
        request()->subcategory3_slug->name ??
        request()->subcategory2_slug->name ??
        request()->subcategory1_slug->name ??
        request()->category_slug->name ??
        config('app.name')
    }}
@endsection

@section('wrapper-class')
    js-sidebar-slide-main-1 slideout-panel js-sidebar-slide-main-2
@endsection
@section('toggle-class')
    another-page
@endsection

@section('mb-brands-filter')
    <x-mb-brands-filter :productIds="$productIds"/>
@endsection

@section('content')
    <div class="container">
        <div class="row-line no-margin">
            @include('web.layouts.sidebar-menu')

            <div class="catalog">
                @yield('page-products-content')
            </div>

            <x-sidebar-brands-filter :productIds="$productIds"/>
        </div>
    </div>
@endsection

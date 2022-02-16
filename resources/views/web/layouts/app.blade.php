<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-seo :seo="($seoArr ?? null)"/>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed+Slab:300,300i,700%7COpen+Sans:400,600,700,800&amp;subset=cyrillic"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,300,500,700,900&amp;subset=latin,latin-ext,cyrillic"
        rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet"/>
</head>
<body>
@javascript([
    'cartItems' => $cartItems,
    'cartRoute' => $cartRoute,
])
@include("web.layouts.mb-menu")
@yield("mb-brands-filter")
<div class="wrapper @yield('wrapper-class')">
    @include('web.layouts.top-bar-md+')
    @include('web.layouts.top-bar-xs')
    <div class="header-sticky">
        @include('web.layouts.header')
    </div>
    <main>
        @yield('content')
    </main>
    @include('web.layouts.footer')
    @include("web.modals.contact-with-technologist")
    @include("web.modals.consent-processing-personal-data")
    @include("web.layouts.back-to-top")
</div>
@include("web.templates-for-js.sidebar-menu-cart-item")
</body>
</html>

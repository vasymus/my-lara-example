@extends('web.layouts.app')

@section('wrapper-class')
    js-sidebar-slide-main-1 slideout-panel
@endsection
@section('toggle-class')
    another-page
@endsection

@section('content')
    <div class="container">
        <div class="row-line no-margin">
            @include('web.layouts.sidebar-menu')

            <div class="catalog @yield('page-content-wrapper-class')">
                <x-breadcrumbs :breadcrumbs="$breadcrumbs"></x-breadcrumbs>
                @yield('page-content')
            </div>
        </div>
    </div>
@endsection
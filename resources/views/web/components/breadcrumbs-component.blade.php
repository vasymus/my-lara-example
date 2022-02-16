<?php /** @var \Support\Breadcrumbs\BreadcrumbDTO[] $breadcrumbs */ ?>
@if(count($breadcrumbs))
    <div class="row-line row-line__center breadcrumbs">
        @foreach($breadcrumbs as $breadcrumb)
            @if(!empty($breadcrumb->url))
                <a class="breadcrumbs__link" href="{{$breadcrumb->url}}">{{$breadcrumb->name}}</a>
            @else
                <span class="breadcrumbs__link">{{$breadcrumb->name}}</span>
            @endif
        @endforeach
    </div>
@endif

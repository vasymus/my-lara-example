<?php
/**
 * @var \Illuminate\Pagination\LengthAwarePaginator $paginator
 * @var array $elements
**/
?>

<div class="filter-head">
    @if ($paginator->hasPages())
    <div class="column">
        <span class="filter-head__text">Страница:</span>

        @if ($paginator->onFirstPage())
            <span class="filter-head__icon" aria-disabled="true" aria-label="Первая страница">
                <img src="{{asset('images//first-filter-page.gif')}}" alt="">
            </span>
            <span class="filter-head__icon" aria-disabled="true" aria-label="Предыдущая страница">
                <img src="{{asset('images//previous-filter-page.gif')}}" alt="">
            </span>
        @else
            <a href="{{ $paginator->toArray()["first_page_url"] }}" class="filter-head__icon" aria-label="Первая страница">
                <img src="{{asset('images//first-filter-page.gif')}}" alt="">
            </a>
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="filter-head__icon" aria-label="Предыдущая страница">
                <img src="{{asset('images//previous-filter-page.gif')}}" alt="">
            </a>
        @endif

        {{-- Pagination Elements --}}
        @php $hadElementString = false; @endphp
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="filter-head__text" aria-disabled="true">@if($hadElementString)&rarr;@else&larr;@endif</span>
                @php $hadElementString = true @endphp
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="filter-head__active" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="filter-head__link">{{$page}}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{$paginator->nextPageUrl()}}" class="filter-head__icon" aria-label="Следующая страница">
                <img src="{{asset('images//next-filter-page.gif')}}" alt="">
            </a>
            <a href="{{$paginator->toArray()["last_page_url"]}}" class="filter-head__icon" aria-label="Последняя страница">
                <img src="{{asset('images//last-filter-page.gif')}}" alt="">
            </a>
        @else
            <span class="filter-head__icon" aria-disabled="true" aria-label="Следующая страница">
                <img src="{{asset('images//next-filter-page.gif')}}" alt="">
            </span>
            <span class="filter-head__icon" aria-disabled="true" aria-label="Последняя страница">
                <img src="{{asset('images//last-filter-page.gif')}}" alt="">
            </span>
        @endif
    </div>
    @endif

    <div class="column">
        <span>Показывать по</span>
        <select class="js-form-select-autosubmit" data-form="{{request()->fullUrlWithQuery(request()->query())}}">
            <option selected="selected" value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        @if($paginator->total() > 0)
            <span>{{$paginator->currentPage()}} - {{min($paginator->currentPage() + $paginator->perPage(), $paginator->total())}} из </span>
        @else
            <span>0 из</span>
        @endif
        <span> {{$paginator->total()}}</span>
    </div>
</div>

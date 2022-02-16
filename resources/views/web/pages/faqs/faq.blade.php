@extends('web.pages.page-layout')

@section('page-content')
    <?php /** @var \Domain\FAQs\Models\FAQ $faq */ ?>
    <x-h1 :entity="$faq"></x-h1>

    <div class="questions-page">
        <h1 class="questions-page__title">{{$faq->name}}</h1>
        <div class="questions-list__row questions-list__row--margin-top">
            <div class="questions-list__avatar">
                <img src="{{asset("images/person.png")}}" width="97" alt="">
            </div>
            @if($faq->created_at)<span class="faq-date"><time datetime="{{$faq->created_at->format("Y-m-d")}}">{{$faq->created_at->format("d.m.Y")}}</time></span>@endif
        </div>
        <div class="questions-list__comment">
            {!! $faq->question !!}
        </div>

        <div class="questions-list__answer">
            {!! $faq->answer !!}
        </div>

        @if($faq->children->isNotEmpty())
            @foreach($faq->children as $child)
                <?php /** @var \Domain\FAQs\Models\FAQ $child */ ?>
                <div class="questions-list__row">
                    <div class="questions-list__avatar">
                        <img src="{{asset("images/person.png")}}" width="97" alt="">
                    </div>
                    <h4 class="questions-list__title">{{$child->name}}</h4>
                    @if($child->created_at)
                        <span class="questions-list__date">
                            <time datetime="{{$child->created_at->format("Y-m-d")}}">{{$child->created_at->format("d.m.Y")}}</time>
                        </span>
                    @endif
                </div>
                <div class="questions-list__comment">
                    {!! $child->question !!}
                </div>
                <div class="questions-list__answer">
                    {!! $child->answer !!}
                </div>
            @endforeach
        @endif
        <div class="row-line row-line__between">
            <a href="{{route("faq.index")}}">
                <img width="213" height="36" src="{{asset("images/general/back-question.svg")}}" alt="">
            </a>
            <a href="{{route("ask")}}">
                <img width="152" height="36" src="{{asset("images/general/ask-question.svg")}}" alt="">
            </a>
        </div>
    </div>
@endsection

@extends('web.pages.page-layout')

@section('page-content')
    <x-h1 :entity="'Вопросы и ответы'"></x-h1>
    <div class="row-line row-line__right">
        <div class="column-back">
            <a href="#" title="вернуться на предыдущую страницу" class="btn-back js-back">
                <img src="{{asset("images/general/backarow.svg")}}" width="97" alt="">
            </a>
        </div>
    </div>
    <div class="questions-page">
        <div class="questions-page__row">
            <h1 class="questions-page__title">Вопросы и ответы</h1>
            <a href="#" class="questions-page__ask-link">
                <img src="{{asset("images/general/ask.png")}}" alt="">
            </a>
        </div>
        <ul class="questions-list">
            @foreach($faqs as $faq)
                <?php /** @var \Domain\FAQs\Models\FAQ $faq */ ?>
                <li class="questions-list__item">
                    <div class="questions-list__row">
                        <div class="questions-list__avatar">
                            <img src="{{asset("images/person.png")}}" width="97" alt="">
                        </div>
                        <h4 class="questions-list__title"><a href="{{route("faq.show", $faq->slug)}}">{{$faq->name}}</a></h4>
                    </div>
                    <div class="questions-list__comment">
                        {!! $faq->question !!}
                    </div>
                    <div class="questions-list__row">
                        <a class="questions-list__more" href="{{route("faq.show", $faq->slug)}}">Подробнее</a>
                        @if($faq->created_at)<span class="questions-list__date"><time datetime="{{$faq->created_at->format("Y-m-d")}}">{{$faq->created_at->format("d.m.Y")}}</time></span>@endif
                    </div>
                </li>
            @endforeach
        </ul>

        {{ $faqs->onEachSide(1)->links('web.pagination.default') }}
    </div>
@endsection

<?php /** @var \Domain\Products\DTOs\ViewedDTO[]|\Illuminate\Database\Eloquent\Collection $viewed */ ?>
@if($viewed->isNotEmpty())
<div class="watched-block">
    <h4 class="watched-block__title">Вы смотрели</h4>
    <div class="watched-block__body">
        @foreach($viewed as $viewedItem)
        <div class="row-line">
            <div class="column">
                @if($viewedItem->image_url)
                <a href="{{$viewedItem->web_route}}">
                    <img
                        width="40"
                        height="40"
                        align="left"
                        src="{{$viewedItem->image_url}}"
                        style="margin-right: 10px;"
                        alt="{{$viewedItem->name}}"
                    />
                </a>
                @endif
            </div>
            <div class="column">
                <div class="product-special">
                    <a title="{{$viewedItem->name}}" href="{{$viewedItem->web_route}}">{!! $viewedItem->name !!}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

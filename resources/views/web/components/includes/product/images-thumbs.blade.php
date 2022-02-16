<?php /** @var string[] $imagesUrls */ ?>
<?php /** @var string[] $imagesThumbs */ ?>
@if(count($imagesUrls) > 0)
    <div class="wrapper-photos-block">
        <div class="line">
            <a href="javascript:;" data-fancybox-trigger="images" class="wrapper-photos-block__link-img">
                Фото ({{count($imagesUrls)}})
                <svg style="width: 15px; height: 15px; color: #000;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M508.5 481.6l-129-129c-2.3-2.3-5.3-3.5-8.5-3.5h-10.3C395 312 416 262.5 416 208 416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c54.5 0 104-21 141.1-55.2V371c0 3.2 1.3 6.2 3.5 8.5l129 129c4.7 4.7 12.3 4.7 17 0l9.9-9.9c4.7-4.7 4.7-12.3 0-17zM208 384c-97.3 0-176-78.7-176-176S110.7 32 208 32s176 78.7 176 176-78.7 176-176 176z"></path>
                </svg>
            </a>
        </div>
        <div class="images-container">
            <div class="row-line">
                @foreach($imagesUrls as $index => $image)
                    <a href="{{$image}}" data-fancybox="images" class="wrapper-photos-block__link"><img src="{{$imagesThumbs[$index] ?? $image}}" alt="" title=""></a>
                @endforeach
            </div>
        </div>
    </div>
@endif

<?php /** @var \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $instructions */ ?>
@if(count($instructions))
    <div>
        @if(count($instructions) === 1)
            <a class="put-product__download" target="_blank" href="{{$instructions->first()->getFullUrl()}}">Скачать инструкции</a>
        @else
            <div class="dropdown">
                <a class="put-product__download" href="#" role="button" id="js-product-files" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Скачать инструкции
                </a>

                <div class="dropdown-menu" aria-labelledby="js-product-files">
                    @foreach($instructions as $instruction)
                        <?php /** @var \Spatie\MediaLibrary\MediaCollections\Models\Media $instruction */ ?>
                        <a class="dropdown-item" target="_blank" href="{{$instruction->getFullUrl()}}">{{$instruction->name}}</a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endif

<div id="extra" class="sidebar-filter">
    <div class="sidebar-filter__content">
        <div class="sidebar-filter__title">
            <span class="sidebar-filter__check">
                <i class="fa fa-check" aria-hidden="true"></i>
            </span>
            Производители:
        </div>
        <form action="{{url()->current()}}" id="filter-form" class="filter-form">

            @foreach($brands as $brand)
                <?php /** @var \Domain\Products\Models\Brand $brand*/ ?>
                <div class="filter-form__item">
                    <input id="acm-brand-{{$brand->id}}" class="filter-form__checkbox" name="brands[]" value="{{$brand->id}}" type="checkbox"/>
                    <label for="acm-brand-{{$brand->id}}" class="filter-form__label">
                        <div class="filter-form__article">
                            <a href="{{route("brands.show", $brand->slug)}}" target="_blank" class="filter-form__link">{{$brand->name}}</a>
                            <span class="filter-product-count">{{$brand->products_count}}</span>
                        </div>
                    </label>
                </div>
            @endforeach

            <div class="filter-form__item">
                <button type="submit" class="filter-form__submit">Выбрать</button>
                <button type="submit" class="filter-form__reset" name="brands[]">Сбросить</button>
            </div>
        </form>
    </div>
</div>

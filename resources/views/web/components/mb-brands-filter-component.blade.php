<div class="js-sidebar-slide-menu-2 filter-mobile">
    <div class="filter-mobile__body">
        <button type="button" class="filter-mobile__close js-sidebar-slide-toggle-2">Закрыть фильтры</button>
        <form action="#" id="filter-form-sidebar" class="filter-form">
            @foreach($brands as $brand)
                <?php /** @var \Domain\Products\Models\Brand $brand*/ ?>
                <div class="filter-form__item">
                    <input id="acm-sidebar" class="filter-form__checkbox" name="brands[]" value="{{$brand->id}}" type="checkbox"/>
                    <label for="acm-sidebar" class="filter-form__label">
                        <div class="filter-form__article">
                            <a href="#" class="filter-form__link">{{$brand->name}}</a>
                            <span class="filter-product-count">{{$brand->products_count}}</span>
                        </div>
                    </label>
                </div>
            @endforeach
            <div class="filter-form__item">
                <input type="submit" class="filter-form__submit" value="Выбрать">
                <input type="button" class="filter-form__reset" value="Сбросить">
            </div>
        </form>
    </div>
</div>

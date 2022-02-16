<div class="sidebar-catalog__header-line">
    <span><i class="fa fa-bars" aria-hidden="true"></i>Каталог товаров</span>
    <span class="sidebar-catalog__search-icon">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
        <path fill="currentColor" d="M508.5 481.6l-129-129c-2.3-2.3-5.3-3.5-8.5-3.5h-10.3C395 312 416 262.5 416 208 416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c54.5 0 104-21 141.1-55.2V371c0 3.2 1.3 6.2 3.5 8.5l129 129c4.7 4.7 12.3 4.7 17 0l9.9-9.9c4.7-4.7 4.7-12.3 0-17zM208 384c-97.3 0-176-78.7-176-176S110.7 32 208 32s176 78.7 176 176-78.7 176-176 176z"></path>
    </svg>
</span>
</div>

<div class="pure-menu-list">
    @foreach($categories as $category)
    <?php /** @var \Domain\Products\Models\Category $category */ ?>
        <div class="pure-menu-item pure-menu-has-children accordion-item">
            <a href="{{route("products.index", [$category->slug])}}" class="pure-menu-link">{{$category->name}}</a>
        </div>
        <div class="data">
            <ul class="pure-menu-children">
                @foreach($category->subcategories as $subcategory1)
                    <li class="pure-menu-item">
                        <a href="{{route("products.index", [$category->slug, $subcategory1->slug])}}" class="pure-menu-link">{{$subcategory1->name}}</a>
                        @if($subcategory1->subcategories->isNotEmpty())
                            <ul class="submenu">
                                @foreach($subcategory1->subcategories as $subcategory2)
                                    <li><a href="{{route("products.index", [$category->slug, $subcategory1->slug, $subcategory2->slug])}}">{{$subcategory2->name}}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>

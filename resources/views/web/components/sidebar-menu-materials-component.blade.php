<div class="menu-sidebar">
    <h3 class="menu-sidebar__title">
        <i class="fa fa-bars" aria-hidden="true"></i>
        Паркетные материалы
    </h3>

    <ul class="dropdown-vertical menu-sidebar__list">
    @foreach($categories as $category)
    <?php /** @var \Domain\Products\Models\Category $category */ ?>
        <li class="accordion-toggle menu-sidebar__item">
            <div class="dropdown-border"></div>
            <a href="#">{{$category->name}}</a>
            @php
                $sidebarDividerCount = \Domain\Products\Models\Category::getSidebarDividerCount($category);
                $subcategories1Part1 = $category->subcategories->take($sidebarDividerCount);
                $subcategories1Part2 = $category->subcategories->skip($sidebarDividerCount);
            @endphp

            <ul>
                <li>
                    @foreach($subcategories1Part1 as $subcategory1Part1)
                        <?php /** @var \Domain\Products\Models\Category $subcategory1Part1 */ ?>
                        <p class="dropdown-level_2">
                            <a class="text-bold" href="{{route("products.index", [ $category->slug, $subcategory1Part1->slug ?? null ])}}">{{$subcategory1Part1->name ?? null}}</a>
                        </p>
                        @if($subcategory1Part1->subcategories->isNotEmpty())
                            <div class="dropdown-level_3_wrapper">
                            @foreach($subcategory1Part1->subcategories as $subcategory2)
                                <?php /** @var \Domain\Products\Models\Category $subcategory2 */ ?>
                                <p class="dropdown-level_3 text-small"><a href="{{route("products.index", [ $category->slug, $subcategory1Part1->slug, $subcategory2->slug ])}}">- {{$subcategory2->name}}</a></p>
                            @endforeach
                            </div>
                        @endif
                    @endforeach
                </li>

                <li class="last">
                    @foreach($subcategories1Part2 as $subcategory1Part2)
                        <?php /** @var \Domain\Products\Models\Category $subcategory1Part2 */ ?>
                        <p class="dropdown-level_2">
                            <a class="text-bold" href="{{route("products.index", [ $category->slug, $subcategory1Part2->slug ?? null ])}}">{{$subcategory1Part2->name ?? null}}</a>
                        </p>
                        @if($subcategory1Part1->subcategories->isNotEmpty())
                            <div class="dropdown-level_3_wrapper">
                                @foreach($subcategory1Part2->subcategories as $subcategory2)
                                    <?php /** @var \Domain\Products\Models\Category $subcategory2 */ ?>
                                    <p class="dropdown-level_3 text-small"><a href="{{route("products.index", [ $category->slug, $subcategory1Part2->slug ?? null, $subcategory2->slug ?? null ])}}">- {{$subcategory2->name ?? null}}</a></p>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </li>
            </ul>
        </li>
    @endforeach
    </ul>
</div>

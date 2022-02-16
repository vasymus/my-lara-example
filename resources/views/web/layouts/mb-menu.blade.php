<div class="gtk_menu js-sidebar-slide-menu-1 slideout-menu menu_main" style="padding-top: 0">
    <div class="mb-body-left">
        {{--<div class="header-column">
            <div class="row-line row-line__between">
                <a href="#" class="logo">
                    <img alt="Parket Lux" title="Parket Lux" src="{{asset("images//logo.svg")}}">
                </a>
                <a class="toggle opened" href="#"> </a>
            </div>
            <div class="search-block js-search-event">
                <form action="#">
                    <div class="search-field">
                        <input type="text" name="q" value="" placeholder="Что вы ищете?">
                        <input name="s" type="submit" value="">
                    </div>
                </form>
            </div>
        </div>--}}
        <div class="sidebar-catalog accordion fltr">
            @include("web.layouts.mb-menu-services")

            <x-mb-menu-materials />
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="{{ config('admin_navbar_menu.menu_items.dashboard.url', 'menus') }}">
            <img src="{{ get_public_asset('backend/assets/media/logos/logo.png') }}" width="160px" alt="{{ config('constants.plugin_name', 'config') }}">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @if(!empty(config('admin_navbar_menu.menu_items', 'menus')))
                    @foreach(config('admin_navbar_menu.menu_items', 'menus') as $item)
                        @if(isset($item['sub_menu_items']) && !empty($item['sub_menu_items']))
                            <!-- Dropdown menu for items with sub_menu_items -->
                            <li class="nav-item pt-2 dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Options
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach($item['sub_menu_items'] as $sub_item)
                                        <li><a class="dropdown-item" href="{{ $sub_item['url'] }}">{{ $sub_item['name'] }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <!-- Regular menu item -->
                            <li class="nav-item pt-2">
                                <a class="nav-link" href="{{ $item['url'] }}">{{ $item['name'] }}</a>
                            </li>
                        @endif
                    @endforeach
                @else
                    <li class="nav-item pt-2">
                        No Menu Items in menus.config
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

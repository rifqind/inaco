<div class="leftbar">
    <!-- Start Sidebar -->
    <div class="sidebar">
        <!-- Start Logobar -->
        <div class="logobar d-flex align-items-center justify-content-center">
            <a href="{{route('web.home')}}" class="logo logo-large"><img src="{{ asset('assets/images/Logo_inaco.png')}}" style="height: 40px;width: auto;" class="img-fluid" alt="logo"></a>
            <a href="{{route('web.home')}}" class="logo logo-small"><img src="{{ asset('assets/images/Logo_inaco.png')}}" class="img-fluid" alt="logo"></a>
            <div class="logo logo-large ml-1 text-logo">- CMS</div>
        </div>
        <!-- End Logobar -->
        <!-- Start Navigationbar -->
        <div class="navigationbar">
            <ul class="vertical-menu">
                <!-- <li>
                    <a href="{{route('banner.list')}}">
                        <i class="ion ion-md-home"></i><span>Home - Banner</span>
                    </a>
                </li> -->
                <!-- <li>
                    <a href="javaScript:void();">
                        <i class="ion ion-ios-business"></i><span>Company</span><i class="feather icon-chevron-right pull-right"></i>
                    </a>
                    <ul class="vertical-submenu">
                        <li><a href="https://inaco.havordigital.com/webappcms/pages/update/7">About Us</a></li>
                        <li><a href="https://inaco.havordigital.com/webappcms/pages/update/8">Company Profile</a></li>
                        <li><a href="/">Factory Tour</a></li>
                        <li><a href="/">Awards</a></li>
                        <li><a href="/">Find Us</a></li>
                    </ul>
                </li> -->
                @foreach ($sidebarItems as $value)
                <li>
                    @if ($value->parent_menu == 0)
                    @if($value->hasChildren)
                    <a href="javaScript:void();">
                        <i class="{{ $value->icon_on_cms }}"></i><span>{{ $value->menu_title }}</span><i class="feather icon-chevron-right pull-right"></i>
                    </a>
                    <ul class="vertical-submenu">
                        @foreach ($childrenItems as $child)
                        @if($child->parent_menu == $value->menu_id)
                        <li><a href="{{ $child->menu_cms_url }}">{{ $child->menu_title }}</a></li>
                        @endif
                        @endforeach
                    </ul>
                    @else
                    <a href="{{ $value->menu_cms_url }}">
                        <i class="{{ $value->icon_on_cms }}"></i><span>{{ $value->menu_title }}</span>
                    </a>
                    @endif
                    @endif
                </li>
                @endforeach
                <!-- <li>
                    <a href="javaScript:void();">
                        <i class="ion ion-logo-buffer"></i><span>Products</span><i class="feather icon-chevron-right pull-right"></i>
                    </a>
                    <ul class="vertical-submenu">
                        <li><a href="{{ route('products-category.list') }}">Category</a></li>
                        <li><a href="{{ route('products.list') }}">SKU</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('recipes.list') }}">
                        <i class="ion ion-md-wine"></i><span>Recipe</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('distributor.list') }}">
                        <i class="ion ion-ios-map"></i><span>Distributors</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('inter-market.list')}}">
                        <i class="ion ion-ios-globe"></i><span>International Market</span>
                    </a>
                </li>
                <li>
                    <a href="javaScript:void();">
                        <i class="ion ion-ios-book"></i><span>News</span><i class="feather icon-chevron-right pull-right"></i>
                    </a>
                    <ul class="vertical-submenu">
                        <li><a href="{{ route('news.list') }}?news_category=1">Articles</a></li>
                        <li><a href="{{ route('news.list') }}?news_category=2">Press Release</a></li>
                    </ul>
                </li> -->

                <!-- <li>
                    <a href="#">
                        <i class="ion ion-ios-school"></i><span>Careers</span>
                    </a>
                </li> -->
                @if ($showSettings)
                <li>
                    <hr />
                </li>
                <li>
                    <a href="javaScript:void();">
                        <i class="ion ion-ios-settings"></i><span>Settings</span><i class="feather icon-chevron-right pull-right"></i>
                    </a>
                    <ul class="vertical-submenu">
                        <li><a href="{{ route('pages.list') }}">Pages</a></li>
                        <li><a href="{{ route('subpages.list') }}">Sub Pages</a></li>
                        <li><a href="{{ route('socmed-marketplace.social-media.list') }}">Social Media</a></li>
                        <li><a href="{{ route('socmed-marketplace.marketplace.list') }}">Market Place</a></li>
                        <li><a href="{{ route('language.list') }}">Language</a></li>
                        <li><a href="{{ route('segment.list') }}">Product Segment</a></li>
                        <li><a href="{{ route('menu.list') }}">Menu Navigation</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javaScript:void();">
                        <i class="ion ion-md-people"></i><span>Users Management</span><i class="feather icon-chevron-right pull-right"></i>
                    </a>
                    <ul class="vertical-submenu">
                        <li><a href="{{ route('user.role.list') }}">Roles</a></li>
                        <li><a href="{{ route('user.permission.list') }}">Permissions</a></li>
                        <li><a href="{{route('user.list')}}">Users</a></li>
                    </ul>
                </li>
                @endif
                <li>
                    <hr />
                </li>
                <li>
                    <a href="javaScript:void();" id="logout">
                        <i class="ion ion-ios-log-out">
                            <form action="{{ route('logout') }}" method="POST" id="logout-button">
                            </form>
                        </i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Navigationbar -->
    </div>
    <!-- End Sidebar -->
</div>
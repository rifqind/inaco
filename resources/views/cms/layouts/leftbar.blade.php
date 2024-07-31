<div class="leftbar">
    <!-- Start Sidebar -->
    <div class="sidebar">
        <!-- Start Logobar -->
        <div class="logobar d-flex align-items-center justify-content-center">
            <a href="index.html" class="logo logo-large"><img src="{{ asset('assets/images/Logo_inaco.png')}}" style="height: 40px;width: auto;" class="img-fluid" alt="logo"></a>
            <a href="index.html" class="logo logo-small"><img src="{{ asset('assets/images/Logo_inaco.png')}}" class="img-fluid" alt="logo"></a>
            <div class="logo logo-large ml-1 text-logo">- CMS</div>
        </div>
        <!-- End Logobar -->
        <!-- Start Navigationbar -->
        <div class="navigationbar">
            <ul class="vertical-menu">
                <li>
                    <a href="{{url('/')}}">
                        <i class="ion ion-md-home"></i><span>Home - Banner</span>
                    </a>
                </li>
                <li>
                    <a href="javaScript:void();">
                        <i class="ion ion-ios-business"></i><span>Company</span><i class="feather icon-chevron-right pull-right"></i>
                    </a>
                    <ul class="vertical-submenu">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Company Profile</a></li>
                        <li><a href="#">Factory Tour</a></li>
                        <li><a href="#">Awards</a></li>
                        <li><a href="#">Find Us</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javaScript:void();">
                        <i class="ion ion-logo-buffer"></i><span>Products</span><i class="feather icon-chevron-right pull-right"></i>
                    </a>
                    <ul class="vertical-submenu">
                        <li><a href="list_product_category.php">Category</a></li>
                        <li><a href="list_product.php">SKU</a></li>
                    </ul>
                </li>
                <li>
                    <a href="list_recipe.php">
                        <i class="ion ion-md-wine"></i><span>Recipe</span>
                    </a>
                </li>
                <li>
                    <a href="javaScript:void();">
                        <i class="ion ion-ios-map"></i><span>Distributors</span><i class="feather icon-chevron-right pull-right"></i>
                    </a>
                    <ul class="vertical-submenu">
                        <li><a href="#">Local</a></li>
                        <li><a href="#">Abroad</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javaScript:void();">
                        <i class="ion ion-ios-globe"></i><span>International Market</span><i class="feather icon-chevron-right pull-right"></i>
                    </a>
                    <ul class="vertical-submenu">
                        <li><a href="#">Country</a></li>
                        <li><a href="#">Products Export</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javaScript:void();">
                        <i class="ion ion-ios-book"></i><span>News</span><i class="feather icon-chevron-right pull-right"></i>
                    </a>
                    <ul class="vertical-submenu">
                        <li><a href="list_news.php?article">Articles</a></li>
                        <li><a href="list_news.php?press_release">Press Release</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#">
                        <i class="ion ion-ios-school"></i><span>Careers</span>
                    </a>
                </li>
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
                        <li><a href="{{ route('social-media.list') }}">Social Media</a></li>
                        <li><a href="{{ route('marketplace.list') }}">Market Place</a></li>
                        <li><a href="#">Language</a></li>
                        <li><a href="{{ route('menu.list') }}">Menu Navigation</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javaScript:void();">
                        <i class="ion ion-md-people"></i><span>Users Management</span><i class="feather icon-chevron-right pull-right"></i>
                    </a>
                    <ul class="vertical-submenu">
                        <li><a href="#">Roles</a></li>
                        <li><a href="#">Permissions</a></li>
                        <li><a href="#">Users</a></li>
                    </ul>
                </li>
                <li>
                    <hr />
                </li>
                <li>
                    <a href="#">
                        <i class="ion ion-ios-log-out"></i><span>Logout</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- End Navigationbar -->
    </div>
    <!-- End Sidebar -->
</div>
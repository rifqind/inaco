 <!-- ======= Header ======= -->
 <header id="header" class="fixed-top header-scrolled">
     <div class="container d-flex align-items-center justify-content-between">

         <h1 class="logo d-sm-none"><a href="index.php"><img title="Logo Inaco" src="{{ asset('assets/web/images/logo.png') }}"></a></h1>

         <nav id="navbar" class="navbar w-100 justify-content-between">
             <ul class=" w-100 justify-content-between">
                 <li class="nav-item dropdown lang d-sm-none">
                     <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                         <img title="Indonesia" src="{{ asset('assets/web/images/ind.png') }}">
                     </a>
                     <ul class="dropdown-menu mx-0 my-0" aria-labelledby="navbarScrollingDropdown">
                         <li class="d-flex align-items-center justify-content-center">
                             <a class="dropdown-item mx-2" href="#"><img title="Indonesia" src="{{ asset('assets/web/images/en.png') }}"></a>
                             <a class="dropdown-item mx-2" href="index-ar.php"><img title="Indonesia" src="{{ asset('assets/web/images/arab.png') }}"></a>
                             <a class="dropdown-item mx-2" href="#"><img title="Indonesia" src="{{ asset('assets/web/images/viet.png') }}"></a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item dropdown has-megamenu">
                     <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"> Company </a>
                     <div class="dropdown-menu megamenu" role="menu">
                         <div class="row">
                             <div class="col-sm-3 d-none d-sm-block">
                                 <div class="image-menu">
                                     <img src="{{ asset('assets/web/images/menu/company-menu.png') }}" class="">
                                 </div>
                             </div>
                             <div class="col-sm-9">
                                 <div class="row list-megamenu">
                                     <div class="col-sm-3">
                                         <div class="megamenu-item"><a href="about.php">About Us</a></div>
                                         <div class="megamenu-item"><a href="">Company Profile</a></div>
                                         <div class="megamenu-item"><a href="">Factory Tour</a></div>
                                         <div class="megamenu-item"><a href="awards.php">Awards</a></div>
                                         <div class="megamenu-item"><a href="findus.php">Find Us</a></div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div> <!-- dropdown-mega-menu.// -->
                 </li>
                 <li class="nav-item dropdown has-megamenu">
                     <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"> Products </a>
                     <div class="dropdown-menu megamenu" role="menu">
                         <div class="row">
                             <div class="col-sm-3 d-none d-sm-block">
                                 <div class="image-menu">
                                     <img src="{{ asset('assets/web/images/menu/products-menu.png') }}" class="">
                                 </div>
                             </div>
                             <div class="col-sm-9">
                                 <div class="row list-megamenu">
                                     <div class="col-sm-4">
                                         <div class="megamenu-item"><a href="catalog.php">ALOE VERA</a></div>
                                     </div>
                                     <div class="col-sm-4">
                                         <div class="megamenu-item"><a href="catalog-remaja.php">CONFECTIONERY</a></div>
                                     </div>
                                     <div class="col-sm-4">
                                         <div class="megamenu-item"><a href="catalog-anak.php">GT PRODUCTS</a></div>
                                     </div>
                                     <div class="col-sm-4">
                                         <div class="megamenu-item"><a href="catalog-anak.php">MINI JELLY</a></div>
                                     </div>
                                     <div class="col-sm-4">
                                         <div class="megamenu-item"><a href="catalog-anak.php">MINI PUDDING</a></div>
                                     </div>
                                     <div class="col-sm-4">
                                         <div class="megamenu-item"><a href="catalog.php">NATA DE COCO</a></div>
                                     </div>
                                     <div class="col-sm-4">
                                         <div class="megamenu-item"><a href="catalog.php">PUDDING</a></div>
                                     </div>
                                     <div class="col-sm-4">
                                         <div class="megamenu-item"><a href="catalog-remaja.php">RTD</a></div>
                                     </div>
                                     <div class="col-sm-4">
                                         <div class="megamenu-item"><a href="catalog-remaja.php">RTD POUCH</a></div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div> <!-- dropdown-mega-menu.// -->
                 </li>
                 <li class="nav-item"><a class="nav-link" href="recipe.php">Recipe</a></li>

                 <li class="nav-item"><a class="nav-link" href="distributor.php">Distributors</a></li>

                 <li class="nav-item logo-item d-none d-sm-block"><a class="nav-link" href="/"><img title="Logo Inaco" src="{{ asset('assets/web/images/logo.png') }}"></a></li>

                 <li class="nav-item"><a class="nav-link" href="market.php">International Market</a></li>

                 <li class="nav-item dropdown has-megamenu">
                     <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"> News </a>
                     <div class="dropdown-menu megamenu" role="menu">
                         <div class="row">
                             <div class="col-sm-3 d-none d-sm-block">
                                 <div class="image-menu">
                                     <img src="{{ asset('assets/web/images/menu/company-menu.png') }}" class="">
                                 </div>
                             </div>
                             <div class="col-sm-9">
                                 <div class="row list-megamenu">
                                     <div class="col-sm-3">
                                         <div class="megamenu-item"><a href="news.php">Article</a></div>
                                         <div class="megamenu-item"><a href="news-press-release.php">Press Release</a></div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div> <!-- dropdown-mega-menu.// -->
                 </li>
                 <li class="nav-item"><a class="nav-link" href="careers.php">Careers</a></li>
                 <li class="nav-item dropdown lang d-none d-sm-block">
                     <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                         <img title="Indonesia" src="{{ asset('assets/web/images/ind.png') }}">
                     </a>
                     <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                         <li><a class="dropdown-item" href="#"><img title="Indonesia" src="{{ asset('assets/web/images/en.png') }}"></a></li>
                         <li><a class="dropdown-item" href="index-ar.php"><img title="Indonesia" src="{{ asset('assets/web/images/arab.png') }}"></a></li>
                         <li><a class="dropdown-item" href="#"><img title="Indonesia" src="{{ asset('assets/web/images/viet.png') }}"></a></li>
                     </ul>
                 </li>
             </ul>
             <i class="bi bi-list mobile-nav-toggle"></i>
         </nav><!-- .navbar -->

     </div>
 </header><!-- End Header -->
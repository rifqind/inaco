<!-- ======= Header ======= -->
<header id="header" class="fixed-top header-scrolled">
    <div class="container d-flex align-items-center justify-content-between">

        <h1 class="logo d-sm-none">
            <a href="index.php">
                <img title="Logo Inaco" src="{{ asset('assets/web/images/logo.png') }}">
            </a>
        </h1>

        <nav id="navbar" class="navbar w-100 justify-content-between">
            <ul class="w-100 justify-content-between">
                <li class="nav-item dropdown lang d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img title="{{ $currentLangImage->name }}"
                            src="{{ asset('data/language') . '/' . $currentLangImage->icon_image }}">
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                        @foreach ($languages as $value)
                            <li class="changeLang">
                                <a class="dropdown-item" href="#" id="change-to-{{ strtolower($value->code) }}">
                                    <img title="{{ $value->name }}"
                                        src="{{ asset('data/language') . '/' . $value->icon_image }}">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <!-- Company Menu -->
                <li id="companyHeader" class="nav-item dropdown has-megamenu">
                    @if ($code == 'id')
                        <a class="nav-link dropdown-toggle" href="#">Perusahaan</a>
                    @elseif ($code == 'ar')
                        <a class="nav-link dropdown-toggle" href="#">شركة</a>
                    @else
                        <a class="nav-link dropdown-toggle" href="#">Company</a>
                    @endif
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
                                        @if($code == 'id')
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.about', ['code' => $code]) }}">Tentang Kami</a>
                                            </div>
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.company-profile', ['code' => $code]) }} ">Profil
                                                    Perusahaan</a></div>
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.factory-tour', ['code' => $code]) }}">Tur Pabrik</a>
                                            </div>
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.awards', ['code' => $code]) }}">Penghargaan</a>
                                            </div>
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.find-us', ['code' => $code]) }}">Temukan Kami</a>
                                            </div>
                                        @elseif($code == 'ar')
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.about', ['code' => $code]) }}">معلومات عنا</a></div>
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.company-profile', ['code' => $code]) }} ">ملف
                                                    الشركة</a></div>
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.factory-tour', ['code' => $code]) }}">جولة في
                                                    المصنع</a></div>
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.awards', ['code' => $code]) }}">الجوائز</a></div>
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.find-us', ['code' => $code]) }}">ابحث عنا</a></div>
                                        @else
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.about', ['code' => $code]) }}">About Us</a></div>
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.company-profile', ['code' => $code]) }} ">Company
                                                    Profile</a></div>
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.factory-tour', ['code' => $code]) }}">Factory
                                                    Tour</a></div>
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.awards', ['code' => $code]) }}">Awards</a></div>
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.find-us', ['code' => $code]) }}">Find Us</a></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- dropdown-mega-menu.// -->
                </li>

                <!-- Products Menu -->
                <li id="produkHeader" class="nav-item dropdown has-megamenu">
                    @if ($code == 'id')
                        <a class="nav-link dropdown-toggle" href="#">Produk</a>
                    @elseif ($code == 'ar')
                        <a class="nav-link dropdown-toggle" href="#">المنتجات</a>
                    @else
                        <a class="nav-link dropdown-toggle" href="#">Products</a>
                    @endif
                    <div class="dropdown-menu megamenu" role="menu">
                        <div class="row">
                            <div class="col-sm-3 d-none d-sm-block">
                                <div class="image-menu">
                                    <img src="{{ asset('assets/web/images/menu/products-menu.png') }}" class="">
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="row list-megamenu">
                                    @foreach ($category as $value)
                                        <div class="col-sm-4">
                                            <!-- <div class="megamenu-item"><a href="{{ route('web.catalog', ['id' => $value->segment, 'code' => $value->language_code, 'category_title' => $value->category_slug]) }}">{{$value->category_title}}</a></div> -->
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.products', ['code' => $value->language_code, 'category_title' => $value->category_slug]) }}">{{$value->category_title}}</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div> <!-- dropdown-mega-menu.// -->
                </li>

                <!-- Additional Menu Items -->
                @if ($code == 'ar')
                    <li class="nav-item"><a class="nav-link" href="{{ route('web.recipe', ['code' => $code]) }}">الإسقاط</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('web.distributor', ['code' => $code]) }}">موزعات
                            التوزيع</a></li>
                    <li class="nav-item logo-item d-none d-sm-block"><a class="nav-link" href="/"><img title="Logo Inaco"
                                src="{{ asset('assets/web/images/logo.png') }}"></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('web.intermarket', ['code' => $code]) }}">السوق
                            الدولية</a></li>
                @elseif ($code == 'id')
                    <li class="nav-item"><a class="nav-link" href="{{ route('web.recipe', ['code' => $code]) }}">Resep</a>
                    </li>
                    <li class="nav-item"><a class="nav-link"
                            href="{{ route('web.distributor', ['code' => $code]) }}">Distributor</a></li>
                    <li class="nav-item logo-item d-none d-sm-block"><a class="nav-link" href="/"><img title="Logo Inaco"
                                src="{{ asset('assets/web/images/logo.png') }}"></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('web.intermarket', ['code' => $code]) }}">Pasar
                            Internasional</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('web.recipe', ['code' => $code]) }}">Recipe</a>
                    </li>
                    <li class="nav-item"><a class="nav-link"
                            href="{{ route('web.distributor', ['code' => $code]) }}">Distributors</a></li>
                    <li class="nav-item logo-item d-none d-sm-block"><a class="nav-link" href="/"><img title="Logo Inaco"
                                src="{{ asset('assets/web/images/logo.png') }}"></a></li>
                    <li class="nav-item"><a class="nav-link"
                            href="{{ route('web.intermarket', ['code' => $code]) }}">International Market</a></li>
                @endif

                <!-- News Menu -->
                <li id="newsHeader" class="nav-item dropdown has-megamenu">
                    @if ($code == 'ar')
                        <a class="nav-link dropdown-toggle" href="#">أخبار</a>
                    @elseif ($code == 'id')
                        <a class="nav-link dropdown-toggle" href="#">Berita</a>
                    @else
                        <a class="nav-link dropdown-toggle" href="#">News</a>
                    @endif
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
                                        @if ($code == 'ar')
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.news', ['id' => 'articles', 'code' => $code]) }}">شرط</a>
                                            </div>
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.news', ['id' => 'press-release', 'code' => $code]) }}">بيان
                                                    صحفي</a></div>
                                        @elseif ($code == 'id')
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.news', ['id' => 'articles', 'code' => $code]) }}">Artikel</a>
                                            </div>
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.news', ['id' => 'press-release', 'code' => $code]) }}">Press
                                                    Release</a></div>
                                        @else
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.news', ['id' => 'articles', 'code' => $code]) }}">Article</a>
                                            </div>
                                            <div class="megamenu-item"><a
                                                    href="{{ route('web.news', ['id' => 'press-release', 'code' => $code]) }}">Press
                                                    Release</a></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- dropdown-mega-menu.// -->
                </li>

                <!-- Careers Menu -->
                @if ($code == 'ar')
                    <li class="nav-item"><a class="nav-link"
                            href="{{ route('web.careers', ['code' => $code]) }}">المهنية</a></li>
                @elseif ($code == 'id')
                    <li class="nav-item"><a class="nav-link" href="{{ route('web.careers', ['code' => $code]) }}">Karir</a>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link"
                            href="{{ route('web.careers', ['code' => $code]) }}">Careers</a></li>
                @endif

                <!-- Language Switcher -->
                <li class="nav-item dropdown lang d-none d-sm-block">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img title="{{ $currentLangImage->name }}"
                            src="{{ asset('data/language') . '/' . $currentLangImage->icon_image }}">
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                        @foreach ($languages as $value)
                            <li class="changeLang">
                                <a class="dropdown-item" href="#" id="change-to-{{ strtolower($value->code) }}">
                                    <img title="{{ $value->name }}"
                                        src="{{ asset('data/language') . '/' . $value->icon_image }}">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>

            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->
    </div>
</header><!-- End Header -->

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.changeLang').forEach((element) => {
            element.addEventListener('click', (event) => {
                event.preventDefault(); // Prevent the default action of the anchor tag
                const langCode = event.target.closest('a').id.split('-')[2];
                const checkCurrentPath = window.location.pathname.split('/').pop();
                let goalPath
                console.log(checkCurrentPath)
                switch (checkCurrentPath) {
                    case 'tentang-kami':
                        goalPath = 'about'
                        break;
                    case 'penghargaan': goalPath = 'awards'
                        break;
                    case 'temukan-kami': goalPath = 'find-us'
                        break;
                    case 'karir': goalPath = 'careers'
                        break;
                    case 'tur-pabrik': goalPath = 'factory-tour'
                        break;
                    case 'profil-perusahaan': goalPath = 'company-profile'
                        break;
                    default:
                        goalPath = checkCurrentPath
                        break;
                }
                const newPath = `/${langCode}/${goalPath}`;
                window.location.href = newPath;
            });
        });
    });
</script>
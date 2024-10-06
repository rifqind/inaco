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
                                <a class="dropdown-item language-list" href="#"
                                    id="change-to-{{ strtolower($value->code) }}">
                                    <img title="{{ $value->name }}"
                                        src="{{ asset('data/language') . '/' . $value->icon_image }}">
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <!-- Company Menu -->
                @if($header['Company'] == 1)
                    <li id="companyHeader" class="nav-item dropdown has-megamenu">
                        @if ($code == 'id')
                            <a class="nav-link dropdown-toggle" href="#">Perusahaan</a>
                        @elseif ($code == 'ar')
                            <a class="nav-link dropdown-toggle" href="#">شركة</a>
                        @elseif ($code == 'vi')
                            <a class="nav-link dropdown-toggle" href="#">Công ty</a>
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
                                            @elseif($code == 'vi')
                                                <div class="megamenu-item"><a
                                                        href="{{ route('web.about', ['code' => $code]) }}">Về Chúng Tôi</a>
                                                </div>
                                                <div class="megamenu-item"><a
                                                        href="{{ route('web.company-profile', ['code' => $code]) }}">Hồ Sơ Công
                                                        Ty</a></div>
                                                <div class="megamenu-item"><a
                                                        href="{{ route('web.factory-tour', ['code' => $code]) }}">Tham Quan Nhà
                                                        Máy</a></div>
                                                <div class="megamenu-item"><a
                                                        href="{{ route('web.awards', ['code' => $code]) }}">Giải Thưởng</a>
                                                </div>
                                                <div class="megamenu-item"><a
                                                        href="{{ route('web.find-us', ['code' => $code]) }}">Tìm Chúng Tôi</a>
                                                </div>
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
                @endif

                @if($header['Products'] == 1)
                    <!-- Products Menu -->
                    <li id="produkHeader" class="nav-item dropdown has-megamenu">
                        @if ($code == 'id')
                            <a class="nav-link dropdown-toggle" href="#">Produk</a>
                        @elseif ($code == 'ar')
                            <a class="nav-link dropdown-toggle" href="#">المنتجات</a>
                        @elseif ($code == 'vi')
                            <a class="nav-link dropdown-toggle" href="#">Sản phẩm</a>
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
                @endif

                <!-- Additional Menu Items -->
                @if ($code == 'ar')
                    @if($header['Recipe'] == 1)
                        <li class="nav-item"><a class="nav-link" href="{{ route('web.recipe', ['code' => $code]) }}">الإسقاط</a>
                        </li>
                    @endif
                    @if($header['Distributors'] == 1)
                        <li class="nav-item"><a class="nav-link" href="{{ route('web.distributor', ['code' => $code]) }}">موزعات
                                التوزيع</a></li>
                    @endif
                    <li class="nav-item logo-item d-none d-sm-block"><a class="nav-link" href="/"><img title="Logo Inaco"
                                src="{{ asset('assets/web/images/logo.png') }}"></a></li>
                    @if($header['International Market'] == 1)
                        <li class="nav-item"><a class="nav-link" href="{{ route('web.intermarket', ['code' => $code]) }}">السوق
                                الدولية</a></li>
                    @endif
                @elseif ($code == 'id')
                    @if($header['Recipe'] == 1)
                        <li class="nav-item"><a class="nav-link" href="{{ route('web.recipe', ['code' => $code]) }}">Resep</a>
                        </li>
                    @endif
                    @if($header['Distributors'] == 1)
                        <li class="nav-item"><a class="nav-link"
                                href="{{ route('web.distributor', ['code' => $code]) }}">Distributor</a></li>
                    @endif
                    <li class="nav-item logo-item d-none d-sm-block"><a class="nav-link" href="/"><img title="Logo Inaco"
                                src="{{ asset('assets/web/images/logo.png') }}"></a></li>
                    @if($header['International Market'] == 1)
                        <li class="nav-item"><a class="nav-link" href="{{ route('web.intermarket', ['code' => $code]) }}">Pasar
                                Internasional</a></li>
                    @endif
                @elseif ($code == 'vi')
                    @if($header['Recipe'] == 1)
                        <li class="nav-item"><a class="nav-link" href="{{ route('web.recipe', ['code' => $code]) }}">Công
                                Thức</a></li>
                    @endif
                    @if($header['Distributors'] == 1)
                        <li class="nav-item"><a class="nav-link" href="{{ route('web.distributor', ['code' => $code]) }}">Nhà
                                Phân Phối</a></li>
                    @endif
                    <li class="nav-item logo-item d-none d-sm-block"><a class="nav-link" href="/"><img title="Logo Inaco"
                                src="{{ asset('assets/web/images/logo.png') }}"></a></li>
                    @if($header['International Market'] == 1)
                        <li class="nav-item"><a class="nav-link" href="{{ route('web.intermarket', ['code' => $code]) }}">Thị
                                Trường Quốc Tế</a></li>
                    @endif
                @else
                    @if($header['Recipe'] == 1)
                        <li class="nav-item"><a class="nav-link" href="{{ route('web.recipe', ['code' => $code]) }}">Recipe</a>
                        </li>
                    @endif
                    @if($header['Distributors'] == 1)
                        <li class="nav-item"><a class="nav-link"
                                href="{{ route('web.distributor', ['code' => $code]) }}">Distributors</a></li>
                    @endif
                    <li class="nav-item logo-item d-none d-sm-block"><a class="nav-link" href="/"><img title="Logo Inaco"
                                src="{{ asset('assets/web/images/logo.png') }}"></a></li>
                    @if($header['International Market'] == 1)
                        <li class="nav-item"><a class="nav-link"
                                href="{{ route('web.intermarket', ['code' => $code]) }}">International Market</a></li>
                    @endif
                @endif

                @if($header['News'] == 1)
                    <!-- News Menu -->
                    <li id="newsHeader" class="nav-item dropdown has-megamenu">
                        @if ($code == 'ar')
                            <a class="nav-link dropdown-toggle" href="#">أخبار</a>
                        @elseif ($code == 'id')
                            <a class="nav-link dropdown-toggle" href="#">Berita</a>
                        @elseif ($code == 'vi')
                            <a class="nav-link dropdown-toggle" href="#">Tin tức</a>
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
                                            @elseif ($code == 'vi')
                                                <div class="megamenu-item"><a
                                                        href="{{ route('web.news', ['id' => 'articles', 'code' => $code]) }}">Bài
                                                        Viết</a>
                                                </div>
                                                <div class="megamenu-item"><a
                                                        href="{{ route('web.news', ['id' => 'press-release', 'code' => $code]) }}">Thông
                                                        Cáo Báo Chí</a></div>
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
                @endif

                @if($header['Career'] == 1)
                    <!-- Careers Menu -->
                    @if ($code == 'ar')
                        <li class="nav-item"><a class="nav-link"
                                href="{{ route('web.careers', ['code' => $code]) }}">المهنية</a></li>
                    @elseif ($code == 'id')
                        <li class="nav-item"><a class="nav-link" href="{{ route('web.careers', ['code' => $code]) }}">Karir</a>
                        </li>
                    @elseif ($code == 'vi')
                        <li class="nav-item"><a class="nav-link" href="{{ route('web.careers', ['code' => $code]) }}">Nghề
                                Nghiệp</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link"
                                href="{{ route('web.careers', ['code' => $code]) }}">Careers</a></li>
                    @endif
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
                                <a class="dropdown-item language-list" href="#"
                                    id="change-to-{{ strtolower($value->code) }}">
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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', () => {
        let nodeElementLang = document.querySelectorAll('.language-list');
        var languageList = [];
        nodeElementLang.forEach((element) => {
            let lang = element.id.split('-')[2];
            languageList.push(lang);
        });
        languageList = [...new Set(languageList)];
        document.querySelectorAll('.changeLang').forEach((element) => {
            element.addEventListener('click', async (event) => {
                event.preventDefault(); // Prevent the default action of the anchor tag
                const langCode = event.target.closest('a').id.split('-')[2];
                const splitPath = window.location.pathname.split('/');
                let goalPath, remainingPath, newPath, response
                remainingPath = splitPath.slice(2).join('/')
                if (!languageList.includes(splitPath[1])) {
                    response = await axios.get(`/change-language/${langCode}/${splitPath[1]}/${remainingPath}`);
                } else {
                    const newSplitPath = remainingPath.split('/');
                    const newRemainingPath = newSplitPath.slice(1).join('/');
                    response = await axios.get(`/change-language/${langCode}/${newSplitPath[0]}/${newRemainingPath}`);
                }
                window.location.href = response.data;
            });
        });
    });
</script>
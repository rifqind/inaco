<!-- ======= Header ======= -->
<header id="header" class="fixed-top header-scrolled">
    <div class="container d-flex align-items-center justify-content-between">

        <h1 class="logo d-sm-none">
            @if ($code == 'id')
            <a href="/">
                <img title="Logo Inaco" src="{{ asset('assets/web/images/logo.png') }}">
            </a>
            @elseif ($code == 'ar')
            <a href="/ar">
                <img title="Logo Inaco" src="{{ asset('assets/web/images/logo.png') }}">
            </a>
            @elseif ($code == 'vi')
            <a href="/vi">
                <img title="Logo Inaco" src="{{ asset('assets/web/images/logo.png') }}">
            </a>
            @else
            <a href="/en">
                <img title="Logo Inaco" src="{{ asset('assets/web/images/logo.png') }}">
            </a>
            @endif
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

                @php
                $totalKeys = count($menuList);
                $halfway = ceil($totalKeys / 2); // Get the halfway point (rounded up if odd)
                @endphp

                @foreach ($menuList as $key => $value )
                @if ($value->parent_menu == 0)
                @if ($value->hasChildren)
                @if ($value->menu_id == 15)
                <li id="produkHeader" class="nav-item dropdown has-megamenu">
                    @elseif ($value->menu_id==21)
                <li id="newsHeader" class="nav-item dropdown has-megamenu">
                    @elseif ($value->menu_id==26)
                <li id="companyHeader" class="nav-item dropdown has-megamenu">
                    @endif
                    <a class="nav-link dropdown-toggle" href="#">{{ $value->menu_title }}</a>
                    <div class="dropdown-menu megamenu" role="menu">
                        <div class="row">
                            <div class="col-sm-3 d-none d-sm-block">
                                <div class="image-menu">
                                    @if ($value->menu_id == 15)
                                    <img src="{{ asset('assets/web/images/menu/products-menu.png') }}">
                                    @else
                                    <img src="{{ asset('assets/web/images/menu/company-menu.png') }}">
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="row list-megamenu">
                                    @if ($value->menu_id == 15)
                                    @foreach ($category as $cat)
                                    <div class="col-sm-4">
                                        <div class="megamenu-item">
                                            <a href="{{ route('web.products', ['code' => $cat->language_code, 'category_title' => $cat->category_slug]) }}">
                                                {{$cat->category_title}}
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach


                                    @else
                                    @foreach ($childrenMenu as $child)
                                    @if ($child->parent_menu == $value->menu_id)
                                    <div class="col-sm-4">
                                        <div class="megamenu-item"><a
                                                href="{{ $child->menu_web_url }}">{{ $child->menu_title }}</a>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach


                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ $value->menu_web_url }}">{{ $value->menu_title }}</a>
                </li>
                @endif
                @endif
                @if ($key + 1 == $halfway)
                <li class="nav-item logo-item d-none d-sm-block">
                    @if ($code=='id')
                    <a class="nav-link" href="/">
                        @else
                        <a class="nav-link" href="/{{$code}}">
                            @endif
                            <img title="Logo Inaco" src="{{ asset('assets/web/images/logo.png') }}">
                        </a>
                </li>
                @endif
                @endforeach

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
                const search = window.location.search
                let goalPath, splitPath, remainingPath, newPath, response
                if (window.location.pathname == '/') {
                    response = await axios.get(`/change-language/${langCode}/index`);
                } else {
                    splitPath = window.location.pathname.split('/');
                    remainingPath = splitPath.slice(2).join('$')
                    console.log(splitPath, remainingPath)
                    if (!languageList.includes(splitPath[1])) {
                        response = await axios.get(`/change-language/${langCode}/${splitPath[1]}/${remainingPath}`, {
                            params: {
                                search: search
                            }
                        });
                    } else {
                        const newSplitPath = remainingPath.split('$');
                        const newRemainingPath = newSplitPath.slice(1).join('$');
                        if (newSplitPath[0] == '')
                            if (langCode == 'id') response = {
                                data: '/'
                            };
                            else
                                response = await axios.get(`/change-language/${langCode}/index`);
                        else
                            response = await axios.get(`/change-language/${langCode}/${newSplitPath[0]}/${newRemainingPath}`, {
                                params: {
                                    search: search
                                }
                            });
                        // if (newSplitPath[0] == '')
                        // console.log('uhuy')
                    }
                }
                window.location.href = response.data;
            });
        });
    });
</script>
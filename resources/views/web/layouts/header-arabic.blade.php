 <!-- ======= Header ======= -->
 <header id="header" class="fixed-top header-scrolled">
     <div class="container d-flex align-items-center justify-content-between">

         <h1 class="logo d-sm-none"><a href="/"><img title="Logo Inaco" src="{{ asset('assets/web/images/logo.webp') }}"></a></h1>

         <nav id="navbar" class="navbar w-100 justify-content-between">
             <ul class=" w-100 justify-content-between">
                 <li class="nav-item dropdown lang d-sm-none">
                     <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                         <img title="{{ $currentLangImage->name }}" src="{{ asset('data/language') . '/' . $currentLangImage->icon_image }}">
                     </a>
                     <ul class="dropdown-menu mx-0 my-0" aria-labelledby="navbarScrollingDropdown">
                         <li class="d-flex align-items-center justify-content-center">
                             @foreach ($languages as $value)
                         <li class="changeLang"><a class="dropdown-item" href="#" id="change-to-{{strtolower($value->code)}}"><img title="{{ $value->name }}" src="{{ asset('data/language') . '/' . $value->icon_image }}"></a></li>
                         @endforeach
                 </li>
             </ul>
             </li>
             <li class="nav-item dropdown has-megamenu">
                 <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"> شركة </a>
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
                                     <div class="megamenu-item"><a href="{{route('web.about', ['code' => $code])}}">معلومات عنا</a></div>
                                     <div class="megamenu-item"><a href="">ملف الشركة</a></div>
                                     <div class="megamenu-item"><a href="">جولة في المصنع</a></div>
                                     <div class="megamenu-item"><a href="{{route('web.awards', ['code' => $code])}}">الجوائز</a></div>
                                     <div class="megamenu-item"><a href="{{route('web.find-us', ['code' => $code])}}">ابحث عنا</a></div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div> <!-- dropdown-mega-menu.// -->
             </li>
             <li class="nav-item dropdown has-megamenu">
                 <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"> المنتجات </a>
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
                                     <div class="megamenu-item"><a href="{{ route('web.catalog', ['id' => $value->segment, 'code' => $value->language_code, 'category_title' => $value->category_slug]) }}">{{$value->category_title}}</a></div>
                                 </div>
                                 @endforeach
                             </div>
                         </div>
                     </div>
                 </div> <!-- dropdown-mega-menu.// -->
             </li>
             <li class="nav-item"><a class="nav-link" href="{{ route('web.recipe', ['code' => $code]) }}">الإسقاط</a></li>
             <li class="nav-item"><a class="nav-link" href="{{ route('web.distributor', ['code' => $code]) }}">موزعات التوزيع</a></li>
             <li class="nav-item logo-item d-none d-sm-block"><a class="nav-link" href="/"><img title="Logo Inaco" src="{{ asset('assets/web/images/logo.webp') }}"></a></li>
             <li class="nav-item"><a class="nav-link" href="{{ route('web.intermarket', ['code' => $code]) }}">السوق الدولية</a></li>
             <li class="nav-item dropdown has-megamenu">
                 <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"> أخبار </a>
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
                                     <div class="megamenu-item"><a href="{{ route('web.news', ['id' => 'articles', 'code' => $code]) }}">شرط</a></div>
                                     <div class="megamenu-item"><a href="{{ route('web.news', ['id' => 'press-release', 'code' => $code]) }}">بيان صحفي</a></div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div> <!-- dropdown-mega-menu.// -->
             </li>
             <li class="nav-item"><a class="nav-link" href="{{ route('web.careers', ['code' => $code]) }}">المهنية</a></li>
             <li class="nav-item dropdown lang d-none d-sm-block">
                 <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                     <img title="{{ $currentLangImage->name }}" src="{{ asset('data/language') . '/' . $currentLangImage->icon_image }}">
                 </a>
                 <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                     @foreach ($languages as $value)
                     <li class="changeLang"><a class="dropdown-item" href="#" id="change-to-{{strtolower($value->code)}}"><img title="{{ $value->name }}" src="{{ asset('data/language') . '/' . $value->icon_image }}"></a></li>
                     @endforeach
                 </ul>
             </li>
             </ul>
             <i class="bi bi-list mobile-nav-toggle"></i>
         </nav><!-- .navbar -->

     </div>
 </header><!-- End Header -->
 <script type="text/javascript">
     const route = window.location;
     document.addEventListener('DOMContentLoaded', () => {
         document.querySelectorAll('.changeLang').forEach((a) => {
             a.addEventListener('click', (event) => {
                 const a = event.target.closest('.dropdown-item')
                 const code = a.id.split('-')[2]
                 const newPath = `${route.origin}/${code}/${route.pathname.split('/').pop()}`
                 window.location.href = newPath
             });
         })
     })
 </script>
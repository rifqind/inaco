<x-web-layout>
    <x-slot name="head"></x-slot>
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="py-0 slide-home-wrapper my-0" data-aos="fade-in">
        <div class="container-fluid p-0 overflow-hidden">
            <div class="row">
                <div class="col-12">
                    <div id="home-slide" class="owl-carousel owl-theme">
                        @if ($banner->isNotEmpty())
                            @foreach ($banner as $value)
                                <div class="item">
                                    <a href="/{{ $value->banner_url }}">
                                        <img src="{{ asset('data/banner') . '/' . $value->banner_image }}?v=11">
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="item">
                                <a href="#">
                                    <img src="{{ asset('assets/web/images/slide4.jpg') }}?v=11">
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero -->

    <main id="main">

        <!-- ======= About ======= -->
        <section id="about-home" class="about-home">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10">
                        <h1 class="page-header text-center mb-4" data-aos="fade-up">{{ $firstText['header'] }}</h1>
                        <div id="about-list" class="owl-carousel owl-theme">
                            @foreach($firstText['items'] as $item)
                                <div class="item" data-aos="fade-up">
                                    <div class="about-wrapper">
                                        <a href="{{ $item['url'] }}">
                                            <div class="image-about">
                                                <img src="{{ asset('assets/web/images/' . $item['image']) }}">
                                            </div>
                                            <div class="content-about">
                                                <div class="title-about">{{ $item['title'] }}</div>
                                                <div class="desc-about">{{ $item['desc'] }}</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= Catalog ======= -->
        <section id="catalog-home" class="catalog-home">
            <div class="container">
                <div class="row w-100" data-aos="fade-up">
                    <div class="col-12 col-md-4">
                        @if($code == 'ar')
                            <h1 class="page-header">المنتجات الرئيسية<br class="d-none d-md-block" /> من اختيارنا</h1>
                            <h3 class="sub-header">بعض منتجات Inaco</h3>
                        @elseif ($code == 'id')
                            <h1 class="page-header">Produk Utama <br class="d-none d-md-block" />Pilihan Kami</h1>
                            <h3 class="sub-header">Beberapa produk Inaco</h3>
                        @elseif ($code == 'vi')
                            <h1 class="page-header">Sản phẩm chính <br class="d-none d-md-block" />Lựa chọn của chúng tôi
                            </h1>
                            <h3 class="sub-header">Một số sản phẩm của Inaco</h3>
                        @else
                            <h1 class="page-header">Main Products <br class="d-none d-md-block" />Our Choice</h1>
                            <h3 class="sub-header">Some Inaco Products</h3>
                        @endif
                        <div class="button-catalog-slide mb-4 pb-2 d-none d-sm-block">
                            <button id="prev-catalog"><i class="bi bi-chevron-left"></i></button>
                            <button id="next-catalog"><i class="bi bi-chevron-right"></i></button>
                        </div>
                        <!-- @if ($code == 'ar')
                            <a href="{{ route('web.products', ['code' => $code]) }}"
                                class="btn btn-primary more filled-button d-none d-sm-inline">انظر جميع المنتجات</a>
                        @elseif ($code == 'id')
                            <a href="{{ route('web.products', ['code' => $code]) }}"
                                class="btn btn-primary more filled-button d-none d-sm-inline">Lihat Semua Produk</a>
                        @elseif ($code == 'vi')
                            <a href="{{ route('web.products', ['code' => $code]) }}"
                                class="btn btn-primary more filled-button d-none d-sm-inline">Xem Tất Cả Sản Phẩm</a>
                        @else
                            <a href="{{ route('web.products', ['code' => $code]) }}"
                                class="btn btn-primary more filled-button d-none d-sm-inline">View All Products</a>
                        @endif -->
                    </div>
                </div>
            </div>
            <div class="container-fluid overflow-hidden px-0">
                <div class="row justify-content-end">
                    <div class="col-12 col-md-8">
                        <div id="catalog-slider" class="owl-carousel owl-theme">
                            @if ($products->isNotEmpty())
                                @foreach ($products as $value)
                                    <div class="item" data-aos="fade-up">
                                        <div class="catalog-thumbnail">
                                            <a
                                                href="{{ route('web.products', ['code' => $code, 'category_title' => $value->category_slug, 'product' => $value->product_slug]) }}">
                                                <div class="image-catalog"><img
                                                        src="{{ asset('data/product') . '/' . $value->product_id . '/' . $value->product_image }}?v=1">
                                                </div>
                                                <div class="content-catalog">
                                                    <div class="title-catalog">
                                                        <h4>{{$value->product_title}}</h4>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <!-- <div class="col-12 text-center">
                        @if ($code == 'id')
                            <a href="{{ route('web.products', ['code' => $code]) }}"
                                class="btn btn-primary more filled-button d-inline-block d-sm-none mt-4">
                                Lihat Semua Produk
                            </a>
                        @elseif ($code == 'ar')
                            <a href="{{ route('web.products', ['code' => $code]) }}"
                                class="btn btn-primary more filled-button d-inline-block d-sm-none mt-4">
                                شاهد جميع المنتجات
                            </a>
                        @elseif ($code == 'vi')
                            <a href="{{ route('web.products', ['code' => $code]) }}"
                                class="btn btn-primary more filled-button d-inline-block d-sm-none mt-4">
                                Xem Tất Cả Sản Phẩm
                            </a>
                        @else
                            <a href="{{ route('web.products', ['code' => $code]) }}"
                                class="btn btn-primary more filled-button d-inline-block d-sm-none mt-4">
                                View All Products
                            </a>
                        @endif
                    </div> -->
                </div>
            </div>
        </section>

        <!-- ======= Article ======= -->
        <section id="article-home" class="article-home">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        @if ($code == 'ar')
                            <h1 class="page-header text-center mb-3" data-aos="fade-up">احرص على الاستمتاع بـ INACO</h1>
                            <h3 class="sub-header text-center mb-5 mt-0" data-aos="fade-up">
                                الملابس والملابس والمشروبات وغيرها الكثير من النصائح التي تجعل الأطعمة أكثر طعمًا مع INACO!
                            </h3>
                        @elseif ($code == 'id')
                            <h1 class="page-header text-center mb-3" data-aos="fade-up">Buat Lebih Enak Dengan INACO</h1>
                            <h3 class="sub-header text-center mb-5 mt-0" data-aos="fade-up">
                                Salad, Kue, Minuman dan masih banyak lagi resep yang membuat hidangan lebih enak dengan
                                INACO!
                            </h3>
                        @elseif ($code == 'vi')
                            <h1 class="page-header text-center mb-3" data-aos="fade-up">Làm cho Món Ăn Ngon Hơn Với INACO
                            </h1>
                            <h3 class="sub-header text-center mb-5 mt-0" data-aos="fade-up">
                                Salad, Bánh Ngọt, Đồ Uống và nhiều mẹo khác để làm cho món ăn ngon hơn với INACO!
                            </h3>
                        @else
                            <h1 class="page-header text-center mb-3" data-aos="fade-up">Make It Taste Better with INACO</h1>
                            <h3 class="sub-header text-center mb-5 mt-0" data-aos="fade-up">
                                Salads, Cakes, Drinks, and many more tips to make dishes taste better with INACO!
                            </h3>
                        @endif
                        <div id="recipe-list" class="owl-carousel owl-theme">
                            @if ($recipes->isNotEmpty())
                                @foreach ($recipes as $value)
                                    <div class="item" data-aos="fade-up">
                                        <div class="recipe-thumbnail mb-0">
                                            <div class="recipe-image">
                                                <img
                                                    src="{{ asset('data/recipe/') }}/{{$value->recipe_id}}/{{$value->recipe_image}}">
                                            </div>
                                            <div class="recipe-content">
                                                <div class="list-product">
                                                    <span>{{$value->product_title}}</span>
                                                </div>
                                                <div class="recipe-title">
                                                    <h4>{{$value->recipe_title}}</h4>
                                                </div>
                                                <div class="recipe-summamry">
                                                    <p>{{$value->recipe_description}}</p>
                                                </div>
                                            </div>
                                            <a href="{{route('web.recipe.detail', ['code' => $code, 'title' => $value->recipe_slug])}}"
                                                class="btn btn-primary w-100 more filled-button">
                                                @if ($code == 'id')
                                                    Lihat Resep
                                                @elseif($code == 'ar')
                                                    شاهد الوصفات
                                                @elseif($code == 'vi')
                                                    Xem Công Thức
                                                @else
                                                    View Recipes
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="text-center" data-aos="fade-up">
                            @if ($code == 'id')
                                <a href="{{ route('web.recipe', ['code' => $code]) }}"
                                    class="btn btn-primary more filled-button mt-4 mt-md-5">
                                    Lihat Semua Resep
                                </a>
                            @elseif ($code == 'ar')
                                <a href="{{ route('web.recipe', ['code' => $code]) }}"
                                    class="btn btn-primary more filled-button mt-4 mt-md-5">
                                    شاهد جميع الوصفات
                                </a>
                            @elseif ($code == 'vi')
                                <a href="{{ route('web.recipe', ['code' => $code]) }}"
                                    class="btn btn-primary more filled-button mt-4 mt-md-5">
                                    Xem Tất Cả Công Thức
                                </a>
                            @else
                                <a href="{{ route('web.recipe', ['code' => $code]) }}"
                                    class="btn btn-primary more filled-button mt-4 mt-md-5">
                                    View All Recipes
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= Article ======= -->
        <section id="news-home" class="news-home mb-5 mb-md-2">
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="d-md-flex justify-content-between align-items-center">
                            <div>
                                @if ($code == 'ar')
                                    <h1 class="page-header mb-2 text-center text-md-start" data-aos="fade-up">Press Release
                                        من INACO</h1>
                                    <h3 class="sub-header mb-4 mt-0 pb-2 text-center text-md-start" data-aos="fade-up">آخر
                                        الأخبار من INACO</h3>
                                @elseif ($code == 'id')
                                    <h1 class="page-header mb-2 text-center text-md-start" data-aos="fade-up">Info dari
                                        INACO</h1>
                                    <h3 class="sub-header mb-4 mt-0 pb-2 text-center text-md-start" data-aos="fade-up">
                                        Berita terbaru dari Inaco</h3>
                                @elseif ($code == 'vi')
                                    <h1 class="page-header mb-2 text-center text-md-start" data-aos="fade-up">Thông cáo báo
                                        chí từ INACO</h1>
                                    <h3 class="sub-header mb-4 mt-0 pb-2 text-center text-md-start" data-aos="fade-up">Tin
                                        tức mới nhất từ INACO</h3>
                                @else
                                    <h1 class="page-header mb-2 text-center text-md-start" data-aos="fade-up">Press Release
                                        from INACO</h1>
                                    <h3 class="sub-header mb-4 mt-0 pb-2 text-center text-md-start" data-aos="fade-up">
                                        Latest news from INACO</h3>
                                @endif

                            </div>

                            <div class="button-news-slide mb-4 pb-2 d-none d-md-block">
                                @if ($news->isNotEmpty())
                                    @if($news->count() >= 4)
                                        <div>
                                            <button id="prev-news"><i class="bi bi-chevron-left"></i></button>
                                            <button id="next-news"><i class="bi bi-chevron-right"></i></button>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div id="news-slider" class="owl-carousel owl-theme">
                            @if ($news->isNotEmpty())
                                @foreach ($news as $value)
                                    <div class="item" data-aos="fade-up">
                                        <div class="thumbnail-article">
                                            <div class="image-thumbnail"><img
                                                    src="{{ asset('data/news') . '/' . $value->news_image }}"></div>
                                            <div class="content-thumbnail">
                                                <div class="title-thumbnail">
                                                    <h4><a
                                                            href="{{ route('web.news', ['id' => $value->news_category, 'code' => $code, 'title' => $value->news_slug]) }}">{{ $value->news_title }}</a>
                                                    </h4>
                                                </div>
                                                <div class="caption-thumbnail">
                                                    <p>{{$value->news_description}}</p>
                                                </div>
                                                <div class="update-article">{{$value->create_date}}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="text-center" data-aos="fade-up">
                            @if ($code == 'ar')
                                <a href="{{ route('web.news', ['id' => 'articles', 'code' => $code]) }}"
                                    class="btn btn-primary more filled-button mt-4 mt-md-5">
                                    انظر جميع النصائح
                                </a>
                            @elseif ($code == 'id')
                                <a href="{{ route('web.news', ['id' => 'articles', 'code' => $code]) }}"
                                    class="btn btn-primary more filled-button mt-4 mt-md-5">
                                    Lihat Lainnya
                                </a>
                            @elseif ($code == 'vi')
                                <a href="{{ route('web.news', ['id' => 'articles', 'code' => $code]) }}"
                                    class="btn btn-primary more filled-button mt-4 mt-md-5">
                                    Xem Thêm
                                </a>
                            @else
                                <a href="{{ route('web.news', ['id' => 'articles', 'code' => $code]) }}"
                                    class="btn btn-primary more filled-button mt-4 mt-md-5">
                                    See More
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('web.layouts.cta-footer')
    </main><!-- End #main -->
    <x-slot name="script"></x-slot>
</x-web-layout>
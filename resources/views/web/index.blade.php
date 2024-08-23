<x-web-layout>
    <x-slot name="head"></x-slot>
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="py-0 slide-home-wrapper my-0" data-aos="fade-in">
        <div class="container-fluid p-0 overflow-hidden">
            <div class="row">
                <div class="col-12">
                    <div id="home-slide" class="owl-carousel owl-theme">
                        <div class="item"><img src="{{ asset('assets/web/images/slide1.jpg')}}?v=11"></div>
                        <div class="item"><a href="{{ route('web.catalog', ['code' => $code,'id' => 'dewasa']) }}"><img src="{{ asset('assets/web/images/slide2.jpg')}}?v=11"></a></div>
                        <div class="item"><a href="{{ route('web.catalog', ['code' => $code,'id' => 'remaja']) }}"><img src="{{ asset('assets/web/images/slide3.jpg')}}?v=11"></a></div>
                        <div class="item"><a href="{{ route('web.catalog', ['code' => $code,'id' => 'anak']) }}"><img src="{{ asset('assets/web/images/slide4.jpg')}}?v=111"></a></div>
                        <div class="item"><a href="catalog-energel.php"><img src="{{ asset('assets/web/images/slide5.jpg')}}?v=11"></a></div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Hero -->

    <main id="main">

        <!-- ======= About ======= -->
        <section id="about-home" class="about-home">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10">
                        <h1 class="page-header text-center mb-4" data-aos="fade-up">Tentang INACO</h1>
                        <div id="about-list" class="owl-carousel owl-theme">
                            <div class="item" data-aos="fade-up">
                                <div class="about-wrapper">
                                    <a href="#">
                                        <div class="image-about"><img src="{{ asset('assets/web/images/award.jpg') }}"></div>
                                        <div class="content-about">
                                            <div class="title-about">Penghargaan</div>
                                            <div class="desc-about">Beberapa penghargaan Inaco</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="item" data-aos="fade-up">
                                <div class="about-wrapper">
                                    <a href="{{route('web.about', ['code' => $code])}}">
                                        <div class="image-about"><img src="{{ asset('assets/web/images/about.jpg') }}"></div>
                                        <div class="content-about">
                                            <div class="title-about">Tentang Kami</div>
                                            <div class="desc-about">Tentang perusahaan Inaco</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="item" data-aos="fade-up">
                                <div class="about-wrapper">
                                    <a href="#">
                                        <div class="image-about"><img src="{{ asset('assets/web/images/profile.jpg') }}"></div>
                                        <div class="content-about">
                                            <div class="title-about">Profil Perusahaan</div>
                                            <div class="desc-about">Informasi tentang profil perusahaan</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
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
                        <h1 class="page-header">Produk Utama <br class="d-none d-md-block" />Pilihan Kami</h1>
                        <h3 class="sub-header">Beberapa produk Inaco</h3>
                        <div class="button-catalog-slide mb-4 pb-2 d-none d-sm-block">
                            <button id="prev-catalog"><i class="bi bi-chevron-left"></i></button>
                            <button id="next-catalog"><i class="bi bi-chevron-right"></i></button>
                        </div>
                        <a href="" class="btn btn-primary more filled-button d-none d-sm-inline">Lihat Semua Produk</a>
                    </div>
                </div>
            </div>
            <div class="container-fluid overflow-hidden px-0">
                <div class="row justify-content-end">
                    <div class="col-12 col-md-8">
                        <div id="catalog-slider" class="owl-carousel owl-theme">
                            @foreach ($products as $value)
                            <div class="item" data-aos="fade-up">
                                <div class="catalog-thumbnail">
                                    <a href="#">
                                        <div class="image-catalog"><img src="{{ asset('data/product'). '/' . $value->product_id .  '/' . $value->product_image }}?v=1"></div>
                                        <div class="content-catalog">
                                            <div class="title-catalog">
                                                <h4>{{$value->product_title}}</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <a href="" class="btn btn-primary more filled-button d-inline-block d-sm-none mt-4">Lihat Semua Produk</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= Article ======= -->
        <section id="article-home" class="article-home">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h1 class="page-header text-center mb-3" data-aos="fade-up">Buat Lebih Enak Dengan INACO</h1>
                        <h3 class="sub-header text-center mb-5 mt-0" data-aos="fade-up">Salad, Kue, Minuman dan masih banyak lagi resep yang membuat hidangan lebih enak dengan INACO!</h3>
                        <div id="recipe-list" class="owl-carousel owl-theme">
                            @foreach ($recipes as $value)
                            <div class="item" data-aos="fade-up">
                                <div class="recipe-thumbnail mb-0">
                                    <div class="recipe-image">
                                        <img src="{{ asset('data/recipe/') }}/{{$value->recipe_image}}">
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
                                        <a href="{{route('web.recipe', ['code' => $code]) . '?title=' . $value->recipe_slug}}" class="btn btn-primary w-100 more filled-button">Lihat Resep</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="text-center" data-aos="fade-up">
                            <a href="{{ route('web.recipe', ['code' => $code]) }}" class="btn btn-primary more filled-button mt-4 mt-md-5">Lihat Semua Resep</a>
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
                                <h1 class="page-header mb-2 text-center text-md-start" data-aos="fade-up">Info dari INACO</h1>
                                <h3 class="sub-header mb-4 mt-0 pb-2 text-center text-md-start" data-aos="fade-up">Berita terbaru dari Inaco</h3>
                            </div>

                            <div class="button-news-slide mb-4 pb-2 d-none d-md-block">
                                <a href="{{route('web.news', ['id' => 'articles', 'code' => $code])}}" class="btn btn-primary more border-0 text-red">Lihat Lainnya</a>
                                <div>
                                    <button id="prev-news"><i class="bi bi-chevron-left"></i></button>
                                    <button id="next-news"><i class="bi bi-chevron-right"></i></button>
                                </div>
                            </div>
                        </div>
                        <div id="news-slider" class="owl-carousel owl-theme">
                            @foreach ($news as $value)
                            <div class="item" data-aos="fade-up">
                                <div class="thumbnail-article">
                                    <div class="image-thumbnail"><img src="{{ asset('data/news') . '/' .$value->news_image }}"></div>
                                    <div class="content-thumbnail">
                                        <div class="title-thumbnail">
                                            <h4><a href="{{route('web.news', ['id' => $value->news_category, 'code' => $code]) . '?title=' . $value->news_slug}}">{{$value->news_title}}</a></h4>
                                        </div>
                                        <div class="caption-thumbnail">
                                            <p>{{$value->news_description}}</p>
                                        </div>
                                        <div class="update-article">{{$value->create_date}}</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="text-center" data-aos="fade-up">
                            <a href="{{route('web.news', ['id' => 'articles', 'code' => $code])}}" class="btn btn-primary more filled-button mt-4 mt-md-5">Lihat Lainnya</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
       @include('web.layouts.cta-footer')
    </main><!-- End #main -->
    <x-slot name="script"></x-slot>
</x-web-layout>
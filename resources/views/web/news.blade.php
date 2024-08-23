<x-web-layout>
    <x-slot name="head"></x-slot>
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="pt-0" data-aos="fade-in">
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-5 pe-md-5 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                    <h1 class="text-white">Artikel Inaco</h1>
                    <p class="text-white">Artikel dan Kabar terbaru. Temukan semua yang ingin Anda ketahui tentang kami.</p>
                </div>
            </div>
        </div>
        <div class="hero-img">
            <img src="{{ asset('assets/web/images/news/news-hero.png') }}" class="img-fluid" alt="Artikel Inaco">
        </div>

    </section>
    <!-- End Hero -->
    <main id="main">
        <section id="article" class="article">
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <h2 class="article-title"><span>Artikel Terbaru</span></h2>
                        <div class="row">
                            @foreach ($news as $value)
                            <div class="col-md-6">
                                <div class="thumbnail-article">
                                    <div class="image-thumbnail"><img src="{{ asset('data/news') . '/' .$value->news_image }}"></div>
                                    <div class="content-thumbnail">
                                        <div class="title-thumbnail">
                                            <h4><a href="{{ route('web.news', ['code'=>$code,'id' => $id]) . '?title=' . $value->news_slug }}">{{$value->news_title}}</a></h4>
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
                    </div>
                    <div class="col-md-4 mt-5 mt-md-0">
                        <div id="popular-article">
                            <h2 class="">Artikel Populer</h2>
                            @foreach ($news as $value)
                            <div class="list-article d-flex">
                                <div class="image-popular"><img src="{{ asset('data/news') . '/' .$value->news_image }}"></div>
                                <div class="content-popular">
                                    <div class="update-article">{{$value->create_date}}</div>
                                    <div class="title-list-article">
                                        <h4><a href="{{ route('web.news', ['code'=>$code,'id' => $id]) . '?title=' . $value->news_slug }}">{{$value->news_title}}</a></h4>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row mt-5 align-items-center">
                    <div class="col-sm-6 text-center text-sm-start">
                        <div class="show-perpage text-sm">Menampilkan 1-{{ $news->count() }} dari {{ $news->total() }} berita</div>
                    </div>
                    <div class="col-sm-6">
                        <nav aria-label="Page navigation article">
                            <ul class="pagination  justify-content-md-end justify-content-center mt-4 mt-md-0">
                                @if($news->currentPage() - 1 != 0)
                                <li class="page-item"><a class="page-link" href="{{ route('web.news', ['code'=>$code,'id' => $id]) }}?currentPage={{ $news->currentPage() - 1 }}">
                                        <
                                            </a>
                                </li>
                                @endif
                                @for ($i = 1; $i <= $news->lastPage(); $i++)
                                    <li class="page-item {{ ($news->currentPage() == $i) ? 'active' : '' }} ">
                                        <a class="page-link" href="{{ route('web.news', ['code'=>$code,'id' => $id]) }}?currentPage={{ $i }}">
                                            {{ $i }}
                                        </a>
                                    </li>
                                    @endfor
                                    @if($news->currentPage() + 1 < $news->lastPage())
                                        <li class="page-item"><a class="page-link" href="{{ route('web.news', ['code'=>$code,'id' => $id]) }}?currentPage={{ $news->currentPage() + 1 }}">></a></li>
                                        @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        @include('web.layouts.cta-footer')
    </main>
    <x-slot name="script"></x-slot>
</x-web-layout>
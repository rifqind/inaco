<x-web-layout>
    <x-slot name="head"></x-slot>
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="pt-0" data-aos="fade-in">
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-5 pe-md-5 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
                    data-aos="fade-up" data-aos-delay="200">
                    @if ($section->isNotEmpty())
                                        {!! $section->filter(function ($item) {
                            return \Illuminate\Support\Str::contains($item->sub_pages_slug, 'bagian-satu');
                        })->first()->sub_pages_description ?? 'Konten belum tersedia' !!}
                    @else
                        @if ($code == 'id')
                            <div class="text-center">Konten belum tersedia</div>
                        @elseif ($code == 'ar')
                            <div class="text-center">المحتوى غير متوفر بعد</div>
                        @elseif ($code == 'vi')
                            <div class="text-center">Nội dung chưa có sẵn</div>
                        @else
                            <div class="text-center">Content not available</div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="hero-img">
            @if ($page)
                <img src="{{ asset('data/pages') . '/' . $page->pages_image }}" class="img-fluid" alt="Artikel Inaco">
            @else
                <img src="{{ asset('assets/web/images/news/news-hero.png') }}" class="img-fluid" alt="Artikel Inaco">
            @endif
        </div>

    </section>
    <!-- End Hero -->
    <main id="main">
        <section id="article" class="article">
            <div class="container" data-aos="fade-up">
                <div class="col-md-12">
                    @if($news->isEmpty())
                        @if ($code == 'id')
                            <div class="text-center">Konten belum tersedia</div>
                        @elseif ($code == 'ar')
                            <div class="text-center">المحتوى غير متوفر بعد</div>
                        @elseif ($code == 'vi')
                            <div class="text-center">Nội dung chưa có sẵn</div>
                        @else
                            <div class="text-center">Content not available</div>
                        @endif
                    @else
                        @if ($code == 'id')
                            <h2 class="article-title"><span>Press Release Terbaru</span></h2>
                        @elseif ($code == 'ar')
                            <h2 class="article-title"><span>بيان صحفي جديد</span></h2>
                        @elseif ($code == 'vi')
                            <h2 class="article-title"><span>Thông cáo báo chí mới</span></h2>
                        @else
                            <h2 class="article-title"><span>Latest Press Release</span></h2>
                        @endif
                        <div class="row">
                            @foreach ($news as $value)
                                <div class="col-md-6">
                                    <div class="thumbnail-article ">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="image-thumbnail"><img
                                                        src="{{ asset('data/news') . '/' . $value->news_image }}"></div>
                                            </div>
                                            <div class="col-md-6 ps-md-1">
                                                <div class="content-thumbnail">
                                                    <div class="title-thumbnail">
                                                        <h4><a
                                                                href="{{ route('web.news', ['code' => $code, 'id' => $id, 'title' => $value->news_slug]) }}">{{$value->news_title}}</a>
                                                        </h4>
                                                    </div>
                                                    <div class="caption-thumbnail">
                                                        <p>{{$value->news_description}}</p>
                                                    </div>
                                                    <div class="update-article">{{$value->create_date}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="row mt-5 align-items-center">
                    @if($news->isNotEmpty())
                        <div class="col-sm-6 text-center text-sm-start">
                            @if ($code == 'id')
                                <div class="show-perpage text-sm">Menampilkan 1-{{ $news->count() }} dari {{ $news->total() }}
                                    item</div>
                            @elseif($code == 'ar')
                                <div class="show-perpage text-sm">عرض 1-{{ $news->count() }} من {{ $news->total() }} عنصر</div>
                            @elseif($code == 'vi')
                                <div class="show-perpage text-sm">Hiển thị 1-{{ $news->count() }} trong số {{ $news->total() }}
                                    mục</div>
                            @else
                                <div class="show-perpage text-sm">Showing 1-{{ $news->count() }} of {{ $news->total() }} items
                                </div>
                            @endif
                        </div>
                        @if ($news->lastPage() != 1)
                            <div class="col-sm-6">
                                <nav aria-label="Page navigation article">
                                    <ul class="pagination  justify-content-md-end justify-content-center mt-4 mt-md-0">
                                        @if($news->currentPage() - 1 != 0)
                                            <li class="page-item"><a class="page-link"
                                                    href="{{ route('web.news', ['code' => $code, 'id' => $id]) }}?currentPage={{ $news->currentPage() - 1 }}">
                                                    < </a>
                                            </li>
                                        @endif
                                        @for ($i = 1; $i <= $news->lastPage(); $i++)
                                            <li class="page-item {{ ($news->currentPage() == $i) ? 'active' : '' }} ">
                                                <a class="page-link"
                                                    href="{{ route('web.news', ['code' => $code, 'id' => $id]) }}?currentPage={{ $i }}">
                                                    {{ $i }}
                                                </a>
                                            </li>
                                        @endfor
                                        @if($news->currentPage() + 1 < $news->lastPage())
                                            <li class="page-item"><a class="page-link"
                                                    href="{{ route('web.news', ['code' => $code, 'id' => $id]) }}?currentPage={{ $news->currentPage() + 1 }}">></a>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </section>

        @include('web.layouts.cta-footer')
    </main>
    <x-slot name="script"></x-slot>
</x-web-layout>
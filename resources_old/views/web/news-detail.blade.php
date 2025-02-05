<x-web-layout>
    <x-slot name="head"></x-slot>
    <main id="main">
        <div id="share-section">
            <a href="www.facebook.com"><img src="{{asset('assets/web/images/news/facebook.svg') }}"></a>
            <a href="www.twitter.com"><img src="{{asset('assets/web/images/news/twitter.svg') }}"></a>
            <a href="web.whatsapp.com"><img src="{{asset('assets/web/images/news/wa.svg') }}"></a>
            <a href="www.telegram.com"><img src="{{asset('assets/web/images/news/telegram.svg') }}"></a>
            <a href="www.pinterest.com"><img src="{{asset('assets/web/images/news/pinterest.svg') }}"></a>
            <!-- <a href=""><img src="{{asset('assets/web/images/news/link.svg') }}"></a> -->
        </div>
        <!-- ======= Detail Article ======= -->
        <section id="detail-article" class="detail-article">
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <!-- ======= Breadcrumbs ======= -->
                        <div id="breadcrumbs" class="breadcrumbs">
                            <ol>
                                @if ($code == 'id')
                                    <li><a href="/id">Home</a></li>
                                    <li><a href="{{route('web.news', ['code' => $code, 'id' => $id])}}">Artikel</a></li>
                                @elseif ($code == 'ar')
                                    <li><a href="/ar">الرئيسية</a></li>
                                    <li><a href="{{route('web.news', ['code' => $code, 'id' => $id])}}">مقالة</a></li>
                                @elseif($code == 'vi')
                                    <li><a href="/vi">Trang Chủ</a></li>
                                    <li><a href="{{route('web.news', ['code' => $code, 'id' => $id])}}">Bài Viết</a></li>
                                @else
                                    <li><a href="/">Home</a></li>
                                    <li><a href="{{route('web.news', ['code' => $code, 'id' => $id])}}">Article</a></li>
                                @endif
                                <li>{{$news->news_title}}</li>
                            </ol>
                        </div><!-- End Breadcrumbs -->
                        @if($news)
                            <h1 class="title-detail-article">{{$news->news_title}}</h1>
                            <div class="info-article">{{ $news->create_date }}</div>
                            <div class="detail-image-article">
                                <img src="{{asset('data/news') . '/' . $news->news_image }}">
                            </div>
                            <div class="detail-content-article">
                                {!! $news->news_description !!}
                            </div>
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
        </section>


        <!-- ======= Article ======= -->
        <section id="article" class="article pt-0 mb-5">
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        @if ($code == 'id')
                            <h2 class="article-title"><span>Artikel Terbaru</span></h2>
                        @elseif ($code == 'ar')
                            <h2 class="article-title"><span>أحدث المقالات</span></h2>
                        @elseif ($code == 'vi')
                            <h2 class="article-title"><span>Bài Viết Mới Nhất</span></h2>
                        @else
                            <h2 class="article-title"><span>Latest Articles</span></h2>
                        @endif
                        <div class="row">
                            @if($newsList->isNotEmpty())
                                @foreach ($newsList as $value)
                                    <div class="col-md-6">
                                        <div class="thumbnail-article">
                                            <div class="image-thumbnail"><img
                                                    src="{{asset('data/news') . '/' . $value->news_image }}"></div>
                                            <div class="content-thumbnail">
                                                <div class="title-thumbnail">
                                                    <h4><a href="article-detail.php">{{$value->news_title}}</a></h4>
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

                            <div class="col-12 text-center">
                                @if ($code == 'id')
                                    <a href="{{route('web.news', ['code' => $code, 'id' => $id])}}"
                                        class="btn btn-primary more">Lihat Lainnya</a>
                                @elseif ($code == 'ar')
                                    <a href="{{route('web.news', ['code' => $code, 'id' => $id])}}"
                                        class="btn btn-primary more">عرض المزيد</a>
                                @elseif ($code == 'vi')
                                    <a href="{{route('web.news', ['code' => $code, 'id' => $id])}}"
                                        class="btn btn-primary more">Xem Thêm</a>
                                @else
                                    <a href="{{route('web.news', ['code' => $code, 'id' => $id])}}"
                                        class="btn btn-primary more">View More</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('web.layouts.cta-footer')
    </main>
    <!-- End #main -->
    <x-slot name="script"></x-slot>
</x-web-layout>
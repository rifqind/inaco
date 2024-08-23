<x-web-layout>
    <x-slot name="head"></x-slot>
    <main id="main">
        <div id="share-section">
            <a href=""><img src="{{asset('assets/web/images/news/facebook.svg') }}"></a>
            <a href=""><img src="{{asset('assets/web/images/news/twitter.svg') }}"></a>
            <a href=""><img src="{{asset('assets/web/images/news/wa.svg') }}"></a>
            <a href=""><img src="{{asset('assets/web/images/news/telegram.svg') }}"></a>
            <a href=""><img src="{{asset('assets/web/images/news/pinterest.svg') }}"></a>
            <a href=""><img src="{{asset('assets/web/images/news/link.svg') }}"></a>
        </div>
        <!-- ======= Detail Article ======= -->
        <section id="detail-article" class="detail-article">
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <!-- ======= Breadcrumbs ======= -->
                        <div id="breadcrumbs" class="breadcrumbs">
                            <ol>
                                <li><a href="/">Home</a></li>
                                <li><a href="{{route('web.news', ['code' => $code,'id' => $id])}}">Artikel</a></li>
                                <li>{{$news->news_title}}</li>
                            </ol>
                        </div><!-- End Breadcrumbs -->
                        <h1 class="title-detail-article">{{$news->news_title}}</h1>
                        <div class="info-article">{{ $news->create_date }} · (????) · by <a href="#">????</a></div>
                        <div class="detail-image-article">
                            <img src="{{asset('data/news') . '/' .$news->news_image }}">
                        </div>
                        <div class="detail-content-article">
                            {!! $news->news_description !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- ======= Article ======= -->
        <section id="article" class="article pt-0 mb-5">
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <h2 class="article-title"><span>Artikel Terbaru</span></h2>
                        <div class="row">
                            @foreach ($newsList as $value)
                            <div class="col-md-6">
                                <div class="thumbnail-article">
                                    <div class="image-thumbnail"><img src="{{asset('data/news') . '/' .$value->news_image }}"></div>
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

                            <div class="col-12 text-center">
                                <a href="{{route('web.news', ['code' => $code,'id' => $id])}}" class="btn btn-primary more">Lihat Lainnya</a>
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
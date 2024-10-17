<x-web-layout>
    <x-slot name="head"></x-slot>
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="pt-0" data-aos="fade-in">
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-5 pe-md-5 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
                    data-aos="fade-up" data-aos-delay="200">
                    @if($descriptions)
                        {!! $descriptions->sub_pages_description !!}
                    @else
                        <div class="text-center">Konten belum tersedia</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="hero-img">
            @if ($page)
                <img src="{{ asset('data/pages') . '/' . $page->pages_image }}" class="img-fluid" alt="Tentang Inaco">
            @else
                <img src="{{ asset('assets/web/images/about/about-hero.jpg') }}" class="img-fluid" alt="Tentang Inaco">
            @endif
        </div>
    </section>
    <!-- End Hero -->
    <main id="main">
        
        <!-- ======= About ======= -->
        <section id="about-us" class="about-us">
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">
                    <div class="col-md-9 position-relative">
                        <div class="carousel-container">
                            <div class="carousel slide1">
                                @if ($list_year->isNotEmpty())
                                    @foreach ($list_year as $value)
                                        <div class="carousel-item">
                                            <div class="row justify-content-center">
                                                <div class="col-sm-4 image-history pe-md-0"><img
                                                        src="{{ asset('data/subpages') . '/' . $value->sub_pages_image }}">
                                                </div>
                                                <div class="col-sm-8 pe-md-0 ps-md-0 content-history">
                                                    <div class="year-history">
                                                        <h2>{{$value->sub_pages_title}}</h2>
                                                    </div>
                                                    <div class="caption-history">
                                                        {!! $value->sub_pages_description !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center">Konten belum tersedia</div>
                                @endif
                            </div>

                            <div class="carousel slide2">
                                @if ($list_year->isNotEmpty())
                                    @foreach ($list_year as $value)
                                        <div class="carousel-item"><span class="dot-caraousel"></span><span
                                                class="year-dot">{{ $value->sub_pages_title }}</span></div>
                                    @endforeach
                                @else
                                    <div class="text-center">Konten belum tersedia</div>
                                @endif
                            </div>
                        </div>
                        <div id="about-slide" class="owl-carousel owl-theme d-none">
                            @if ($list_year->isNotEmpty())
                                @foreach ($list_year as $value)
                                    <div class="item">
                                        <div class="row justify-content-center">
                                            <div class="col-sm-4 image-history pe-md-0"><img
                                                    src="{{ asset('data/subpages') . '/' . $value->sub_pages_image }}"></div>
                                            <div class="col-sm-auto pe-md-0 ps-md-0 content-history">
                                                <div class="year-history">
                                                    <h2>{{$value->sub_pages_title}}</h2>
                                                </div>
                                                <div class="caption-history">
                                                    {!! $value->sub_pages_description !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center">Konten belum tersedia</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-11 mt-5">
                        @if ($page)
                            {!! $page->pages_description !!}
                        @else
                            <div class="text-center">Konten belum tersedia</div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        @include('web.layouts.cta-footer')
    </main>
    <x-slot name="script"></x-slot>
</x-web-layout>
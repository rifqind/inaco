<x-web-layout>
    <x-slot name="head"></x-slot>
    <section id="hero" class="pt-0" data-aos="fade-in">
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-5 pe-md-5 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
                    data-aos="fade-up" data-aos-delay="200">
                    @if ($descriptions)
                        {!! $descriptions->sub_pages_description !!}
                    @else
                        <div class="text-center">Konten belum tersedia</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="hero-img">
            @if ($page)
                <img src="{{ asset('data/pages') . '/' . $page->pages_image }}?v=1" class="img-fluid" alt="Factory Inaco">
            @else
                <img src="{{ asset('assets/web/images/about/about-hero.jpg') }}" class="img-fluid" alt="Factory Inaco">
            @endif
        </div>
    </section>
    <main id="main">
        <!-- ======= About ======= -->
        <section id="about-us" class="about-us">
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">
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
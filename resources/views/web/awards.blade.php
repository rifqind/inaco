<x-web-layout>
    <x-slot name="head"></x-slot>

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="pt-0 text-white" data-aos="fade-in">
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-5 pe-md-5 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
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
            <img src="{{ asset('data/pages') . '/' . $page->pages_image }}?v=1" class="img-fluid" alt="Award Inaco">
            @endif
        </div>
    </section>
    <!-- End Hero -->
    <section id="gallery" class="gallery">
        <div class="container" data-aos="fade-up">

            <div class="row parent-container">
                <div class="col-12">
                    <div class="subtext-award">
                        @if ($page)
                        {!! $page->pages_description !!}
                        @else
                        <div class="text-center">Konten belum tersedia</div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        @if ($award_list->isNotEmpty())
                        @foreach ($award_list as $value)
                        <div class="col-lg-3 col-6">
                            <a class="gallery-thumbnail" data-aos="fade-up" title="{{ $value->sub_pages_title }}" content="{{ $value->sub_pages_description }}" href="{{ asset('data/subpages') . '/' . $value->sub_pages_image }}">
                                <div class="image-award"><img src="{{ asset('data/subpages') . '/' . $value->sub_pages_image }}" alt="" id="img-glry"></div>
                                <div class="content-award">
                                    <div class="title-award">{{ $value->sub_pages_title }}</div>
                                    <div class="year-award">{{ $value->sub_pages_description }}</div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                        @else
                        <div class="text-center">Konten belum tersedia</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('web.layouts.cta-footer')
    </main>
    <x-slot name="script"></x-slot>
</x-web-layout>
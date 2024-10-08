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
                        {!! $section->where('sub_pages_slug', 'bagian-satu')->value('sub_pages_description') !!}
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
                <img src="{{ asset('assets/web/images/career/career-hero.jpg') }}" class="img-fluid" alt="Award Inaco">
            @endif
        </div>
    </section>
    <!-- End Hero -->
    <main id="main">
        <!-- ======= Career ======= -->
        <section id="career" class="career">
            <div class="container">
                <div class="row career-image" data-aos="fade-up">
                    <div class="col-12 col-md-7">
                        @if ($section->isNotEmpty())
                            <img src="{{ asset('data/subpages') . '/' . $section->where('sub_pages_slug', 'bagian-dua')->value('sub_pages_image') }}"
                                alt="">
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
                <div class="row career-text justify-content-end" data-aos="fade-up">
                    <div class="col-12 col-md-7">
                        <div class="career-wrapper">
                            @if ($section->isNotEmpty())
                                {!! $section->where('sub_pages_slug', 'bagian-dua')->value('sub_pages_description') !!}
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
                            @if ($page)
                                {!! $page->pages_description !!}
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
            </div>
        </section>

        <!-- ======= Recuritment ======= -->
        <section id="recuritment" class="recuritment text-center">
            <div class="container">
                <div class="row">
                    <div class="col-12" data-aos="fade-up">
                        @if ($section->isNotEmpty())
                            {!! $section->where('sub_pages_slug', 'bagian-tiga')->value('sub_pages_description') !!}
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
                    <div class="col-md-3" data-aos="fade-up">
                        @if ($rekrutmen_step->isNotEmpty())
                                <div class="number-recruitment">1</div>
                                <img
                                    src="{{ asset('data/subpages') . '/' . $rekrutmen_step->where('sub_pages_slug', 'rekrutmen-satu')->value('sub_pages_image') }}">
                                {!! $rekrutmen_step->where('sub_pages_slug', 'rekrutmen-satu')->value('sub_pages_description') !!}
                            </div>
                            <div class="col-md-3" data-aos="fade-up">
                                <div class="number-recruitment">2</div>
                                <img
                                    src="{{ asset('data/subpages') . '/' . $rekrutmen_step->where('sub_pages_slug', 'rekrutmen-dua')->value('sub_pages_image') }}">
                                {!! $rekrutmen_step->where('sub_pages_slug', 'rekrutmen-dua')->value('sub_pages_description') !!}
                            </div>
                            <div class="col-md-3" data-aos="fade-up">
                                <div class="number-recruitment">3</div>
                                <img
                                    src="{{ asset('data/subpages') . '/' . $rekrutmen_step->where('sub_pages_slug', 'rekrutmen-tiga')->value('sub_pages_image') }}">
                                {!! $rekrutmen_step->where('sub_pages_slug', 'rekrutmen-tiga')->value('sub_pages_description') !!}
                            </div>
                            <div class="col-md-3" data-aos="fade-up">
                                <div class="number-recruitment">4</div>
                                <img
                                    src="{{ asset('data/subpages') . '/' . $rekrutmen_step->where('sub_pages_slug', 'rekrutmen-empat')->value('sub_pages_image') }}">
                                {!! $rekrutmen_step->where('sub_pages_slug', 'rekrutmen-empat')->value('sub_pages_description') !!}
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
        </section>

        <!-- ======= CTA Carerer ======= -->
        <section id="contact-career" class="contact-career mb-4">
            <div class="container">
                <div class="row">
                    <div class="col-12" data-aos="fade-up">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <div>
                                @if ($section->isNotEmpty())
                                    {!! $section->where('sub_pages_slug', 'bagian-empat')->value('sub_pages_description') !!}
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
                            <a href="https://job-portal.niramasutama.com" class="btn btn-primary more filled-button">
                                @if ($code == 'id')
                                    Lihat Lowongan Pekerjaan
                                @elseif($code == 'ar')
                                    شاهد فرص العمل
                                @elseif($code == 'vi')
                                    Xem việc làm
                                @else
                                    View Job Vacancies
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('web.layouts.cta-footer')
    </main>
    <x-slot name="script"></x-slot>
</x-web-layout>
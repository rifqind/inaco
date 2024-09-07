<x-web-layout>
    <x-slot name="head"></x-slot>
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="pt-0" data-aos="fade-in">
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-5 pe-md-5 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                    @if ($section->isNotEmpty())
                    {!! $section->where('sub_pages_slug', 'bagian-satu')->value('sub_pages_description') !!}
                    @else
                    <div class="text-center">Konten belum tersedia</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="hero-img">
            <img src="{{ asset('assets/web/images/career/career-hero.jpg') }}" class="img-fluid" alt="Award Inaco">
        </div>
    </section>
    <!-- End Hero -->
    <main id="main">
        <!-- ======= Career ======= -->
        <section id="career" class="career">
            <div class="container">
                <div class="row career-image" data-aos="fade-up">
                    <div class="col-12 col-md-7">
                        <img src="{{ asset('data/subpages') . '/' . $section->where('sub_pages_slug', 'bagian-dua')->value('sub_pages_image') }}" alt="">
                    </div>
                </div>
                <div class="row career-text justify-content-end" data-aos="fade-up">
                    <div class="col-12 col-md-7">
                        <div class="career-wrapper">
                            {!! $section->where('sub_pages_slug', 'bagian-dua')->value('sub_pages_description') !!}
                            {!! $page->pages_description !!}
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
                        {!! $section->where('sub_pages_slug', 'bagian-tiga')->value('sub_pages_description') !!}
                    </div>
                    <div class="col-md-3" data-aos="fade-up">
                        <div class="number-recruitment">1</div>
                        <img src="{{ asset('data/subpages') . '/' . $rekrutmen_step->where('sub_pages_slug', 'rekrutmen-satu')->value('sub_pages_image') }}">
                        {!! $rekrutmen_step->where('sub_pages_slug', 'rekrutmen-satu')->value('sub_pages_description') !!}
                    </div>
                    <div class="col-md-3" data-aos="fade-up">
                        <div class="number-recruitment">2</div>
                        <img src="{{ asset('data/subpages') . '/' . $rekrutmen_step->where('sub_pages_slug', 'rekrutmen-dua')->value('sub_pages_image') }}">
                        {!! $rekrutmen_step->where('sub_pages_slug', 'rekrutmen-dua')->value('sub_pages_description') !!}
                    </div>
                    <div class="col-md-3" data-aos="fade-up">
                        <div class="number-recruitment">3</div>
                        <img src="{{ asset('data/subpages') . '/' . $rekrutmen_step->where('sub_pages_slug', 'rekrutmen-tiga')->value('sub_pages_image') }}">
                        {!! $rekrutmen_step->where('sub_pages_slug', 'rekrutmen-tiga')->value('sub_pages_description') !!}
                    </div>
                    <div class="col-md-3" data-aos="fade-up">
                        <div class="number-recruitment">4</div>
                        <img src="{{ asset('data/subpages') . '/' . $rekrutmen_step->where('sub_pages_slug', 'rekrutmen-empat')->value('sub_pages_image') }}">
                        {!! $rekrutmen_step->where('sub_pages_slug', 'rekrutmen-empat')->value('sub_pages_description') !!}
                    </div>
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
                                {!! $section->where('sub_pages_slug', 'bagian-empat')->value('sub_pages_description') !!}
                            </div>
                            <a href="https://job-portal.niramasutama.com" class="btn btn-primary more filled-button">Lihat Lowongan Pekerjaan</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('web.layouts.cta-footer')
    </main>
    <x-slot name="script"></x-slot>
</x-web-layout>
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
                    @if ($code == 'id')
                        <div class="col-12" data-aos="fade-up">
                            <h2 class="fw-bold">Proses Rekrutmen</h2>
                        </div>
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="number-recruitment">1</div>
                            <img src="{{ asset('assets/web/images/career/icon1.png') }}">
                            <h4>Lamar Online</h4>
                            <p>Lamar Online Kirimkan CV dan surat lamaran Anda melalui situs kami.</p>
                        </div>
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="number-recruitment">2</div>
                            <img src="{{ asset('assets/web/images/career/icon2.png') }}">
                            <h4>Seleksi Awal</h4>
                            <p>Tim HR kami akan meninjau aplikasi Anda.</p>
                        </div>
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="number-recruitment">3</div>
                            <img src="{{ asset('assets/web/images/career/icon3.png') }}">
                            <h4>Interview</h4>
                            <p>Jika terpilih, Anda akan diundang untuk wawancara.</p>
                        </div>
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="number-recruitment">4</div>
                            <img src="{{ asset('assets/web/images/career/icon4.png') }}">
                            <h4>Penawaran</h4>
                            <p>Kami akan menghubungi Anda dengan penawaran jika Anda cocok dengan posisi yang kami cari.</p>
                        </div>
                    @elseif($code == 'ar')
                        <div class="col-12" data-aos="fade-up">
                            <h2 class="fw-bold">عملية التوظيف</h2>
                        </div>
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="number-recruitment">1</div>
                            <img src="{{ asset('assets/web/images/career/icon1.png') }}">
                            <h4>تقديم الطلب عبر الإنترنت</h4>
                            <p>أرسل سيرتك الذاتية وخطاب التقديم عبر موقعنا الإلكتروني.</p>
                        </div>
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="number-recruitment">2</div>
                            <img src="{{ asset('assets/web/images/career/icon2.png') }}">
                            <h4>التصفية الأولية</h4>
                            <p>فريق الموارد البشرية لدينا سيراجع طلبك.</p>
                        </div>
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="number-recruitment">3</div>
                            <img src="{{ asset('assets/web/images/career/icon3.png') }}">
                            <h4>المقابلة</h4>
                            <p>إذا تم اختيارك، ستتم دعوتك لإجراء مقابلة.</p>
                        </div>
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="number-recruitment">4</div>
                            <img src="{{ asset('assets/web/images/career/icon4.png') }}">
                            <h4>العرض</h4>
                            <p>سنتواصل معك بعرض إذا كنت مناسباً للوظيفة المطلوبة.</p>
                        </div>
                    @elseif($code == 'vi')
                        <div class="col-12" data-aos="fade-up">
                            <h2 class="fw-bold">Quy Trình Tuyển Dụng</h2>
                        </div>
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="number-recruitment">1</div>
                            <img src="{{ asset('assets/web/images/career/icon1.png') }}">
                            <h4>Nộp Hồ Sơ Trực Tuyến</h4>
                            <p>Gửi CV và thư xin việc qua trang web của chúng tôi.</p>
                        </div>
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="number-recruitment">2</div>
                            <img src="{{ asset('assets/web/images/career/icon2.png') }}">
                            <h4>Sơ Tuyển</h4>
                            <p>Đội ngũ nhân sự của chúng tôi sẽ xem xét đơn ứng tuyển của bạn.</p>
                        </div>
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="number-recruitment">3</div>
                            <img src="{{ asset('assets/web/images/career/icon3.png') }}">
                            <h4>Phỏng Vấn</h4>
                            <p>Nếu được chọn, bạn sẽ được mời đến phỏng vấn.</p>
                        </div>
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="number-recruitment">4</div>
                            <img src="{{ asset('assets/web/images/career/icon4.png') }}">
                            <h4>Đề Nghị</h4>
                            <p>Chúng tôi sẽ liên hệ với bạn với một đề nghị nếu bạn phù hợp với vị trí mà chúng tôi tìm
                                kiếm.</p>
                        </div>
                    @else
                        <div class="col-12" data-aos="fade-up">
                            <h2 class="fw-bold">Recruitment Process</h2>
                        </div>
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="number-recruitment">1</div>
                            <img src="{{ asset('assets/web/images/career/icon1.png') }}">
                            <h4>Apply Online</h4>
                            <p>Submit your CV and cover letter through our website.</p>
                        </div>
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="number-recruitment">2</div>
                            <img src="{{ asset('assets/web/images/career/icon2.png') }}">
                            <h4>Initial Screening</h4>
                            <p>Our HR team will review your application.</p>
                        </div>
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="number-recruitment">3</div>
                            <img src="{{ asset('assets/web/images/career/icon3.png') }}">
                            <h4>Interview</h4>
                            <p>If selected, you will be invited for an interview.</p>
                        </div>
                        <div class="col-md-3" data-aos="fade-up">
                            <div class="number-recruitment">4</div>
                            <img src="{{ asset('assets/web/images/career/icon4.png') }}">
                            <h4>Offer</h4>
                            <p>We will contact you with an offer if you are a good fit for the position.</p>
                        </div>
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
                                @if ($code == 'id')
                                    <h2 class="">Siap untuk Memulai Karier Anda Bersama Kami?</h2>
                                    <h4 class="mb-4 mb-sm-0">Temukan peluang Anda dan jadilah bagian dari perjalanan kami
                                        menuju kesuksesan.</h4>
                                @elseif ($code == 'ar')
                                    <h2 class="">هل أنت مستعد لبدء مسيرتك المهنية معنا؟</h2>
                                    <h4 class="mb-4 mb-sm-0">اكتشف فرصك وكن جزءًا من رحلتنا نحو النجاح.</h4>
                                @elseif ($code == 'vi')
                                    <h2 class="">Sẵn sàng để bắt đầu sự nghiệp của bạn với chúng tôi?</h2>
                                    <h4 class="mb-4 mb-sm-0">Khám phá cơ hội của bạn và trở thành một phần trong hành trình
                                        thành công của chúng tôi.</h4>
                                @else
                                    <h2 class="">Ready to Start Your Career with Us?</h2>
                                    <h4 class="mb-4 mb-sm-0">Discover your opportunities and be part of our journey towards
                                        success.</h4>
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
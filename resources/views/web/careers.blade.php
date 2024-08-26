<x-web-layout>
    <x-slot name="head"></x-slot>
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="pt-0" data-aos="fade-in">
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-5 pe-md-5 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                    <h1 class="">Careers</h1>
                    <p class="">Bergabunglah dengan Tim Kami dan Jadilah Bagian dari Perubahan</p>
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
                        <img src="{{ asset('assets/web/images/career/career-image.jpg') }}" alt="">
                    </div>
                </div>
                <div class="row career-text justify-content-end" data-aos="fade-up">
                    <div class="col-12 col-md-7">
                        <div class="career-wrapper">
                            <h4>Kami mencari individu berbakat dan berdedikasi yang siap berkontribusi untuk kesuksesan bersama.</h4>
                            <h2 class="fw-bold">Mengapa Bergabung dengan Kami?</h2>
                            <ul>
                                <li><b>Karier yang Berkembang:</b> Kami memberikan kesempatan untuk berkembang dan meningkatkan kemampuan profesional Anda.</li>
                                <li><b>Lingkungan Kerja Positif:</b> Kami menawarkan lingkungan kerja yang dinamis, inklusif, dan penuh dukungan.</li>
                                <li><b>Kompensasi Kompetitif:</b> Kami memberikan paket remunerasi yang menarik dan kompetitif.</li>
                                <li><b>Peluang Inovasi:</b> Bergabunglah dengan tim yang selalu mendorong batasan inovasi dalam industri produk kelapa.</li>
                            </ul>
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
                                <h2 class="">Siap untuk Memulai Karier Anda Bersama Kami?</h2>
                                <h4 class="mb-4 mb-sm-0">Temukan peluang Anda dan jadilah bagian dari perjalanan kami menuju kesuksesan.</h4>
                            </div>
                            <a href="recipe-detail.php" class="btn btn-primary more filled-button">Lihat Lowongan Pekerjaan</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('web.layouts.cta-footer')
    </main>
    <x-slot name="script"></x-slot>
</x-web-layout>
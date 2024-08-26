<x-web-layout>
    <x-slot name="head"></x-slot>

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="pt-0 text-white" data-aos="fade-in">
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-5 pe-md-5 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                    <h1 class="">Find Us</h1>
                    <p class="">Dapatkan informasi lebih lanjut dan tetap terhubung melalui kontak dan media sosial kami.</p>
                </div>
            </div>
        </div>
        <div class="hero-img">
            <img src="{{ asset('assets/web/images/findus/findus-hero.jpg') }}" class="img-fluid" alt="Artikel Inaco">
        </div>

    </section>
    <!-- End Hero -->
    <main id="main">

        <!-- ======= Find Us ======= -->
        <section id="findus" class="findus">
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-5">
                        <h2 class="fw-bold mb-4 pb-2">Contact Detail</h2>
                        <div class="d-flex align-items-start mb-3">
                            <img src="{{ asset('assets/web/images/findus/location.png') }}" class="me-3">
                            <div class="">
                                <h5 class="fw-bold mb-1">Address</h5>
                                <div class="text-grey">Jl. Raya Bekasi Tambun Km 39,5 Bekasi 17510, Indonesia</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <img src="{{ asset('assets/web/images/findus/call.png') }}" class="me-3">
                            <div class="">
                                <h5 class="fw-bold mb-1">Telephone</h5>
                                <div class="text-grey"><a class="text-grey" href="tel:+62218807222">(62-21) 8807222</a>, <a class="text-grey" href="tel:+622188349573">(62-21) 88349573</a></div>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <img src="{{ asset('assets/web/images/findus/message.png') }}" class="me-3">
                            <div class="">
                                <h5 class="fw-bold mb-1">Email</h5>
                                <div class="text-grey"><a class="text-grey" href="mailto:contact@inacofood.com">contact@inacofood.com</a></div>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <img src="{{ asset('assets/web/images/findus/printer.png') }}" class="me-3">
                            <div class="">
                                <h5 class="fw-bold mb-1">Fax</h5>
                                <div class="text-grey">(62 21) 8806966, (62 21) 8801212</div>
                            </div>
                        </div>
                        <hr class="mt-5 mb-4 pt-2 pb-2">
                        <h4 class="fw-bold mb-4">Our Online Shop</h4>
                        <div class="d-flex align-items-center olshop">
                            <a class="me-3" href=""><img src="{{ asset('assets/web/images/findus/lazada.png') }}"></a>
                            <a class="me-3" href=""><img src="{{ asset('assets/web/images/findus/tiktok.png') }}"></a>
                            <a class="me-3" href=""><img src="{{ asset('assets/web/images/findus/tokopedia.png') }}"></a>
                            <a class="me-3" href=""><img src="{{ asset('assets/web/images/findus/shopee.png') }}"></a>
                        </div>
                        <hr class="mt-5 mb-4 pt-2 pb-2 d-sm-none">
                    </div>
                    <div class="col-12 col-sm-7">
                        <form action="">
                            <h2 class="fw-bold mb-3">Send a Message</h2>
                            <div class="text-grey mb-4">We welcome any inquires regarding our products including export inquires. <br>Please complete the form below if you have any feedback regarding our products and services.</div>
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold mb-1">Name</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold mb-1">Email</label>
                                <input type="text" class="form-control" id="email">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label fw-bold mb-1">Phone</label>
                                <input type="text" class="form-control" id="phone">
                            </div>
                            <div class="mb-4">
                                <label for="message" class="form-label fw-bold mb-1">Message</label>
                                <textarea rows="5" class="form-control" id="message"></textarea>
                            </div>
                            <button href="#" class="btn btn-primary px-5 more filled-button">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        @include('web.layouts.cta-footer')
    </main>
    <x-slot name="script"></x-slot>
</x-web-layout>
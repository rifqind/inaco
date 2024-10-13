<x-web-layout>
    <x-slot name="head"></x-slot>

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="pt-0 text-white" data-aos="fade-in">
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-5 pe-md-5 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
                    data-aos="fade-up" data-aos-delay="200">
                    @if ($section->where('sub_pages_slug', 'bagian-satu')->value('sub_pages_description'))
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
                <img src="{{ asset('data/pages') . '/' . $page->pages_image  }}" class="img-fluid" alt="Artikel Inaco">
            @else
                <img src="{{ asset('assets/web/images/findus/findus-hero.jpg')  }}" class="img-fluid" alt="Artikel Inaco">
            @endif
        </div>

    </section>
    <!-- End Hero -->
    <main id="main">

        <!-- ======= Find Us ======= -->
        <section id="findus" class="findus">
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-5">
                        <h2 class="fw-bold mb-4 pb-2"></h2>
                        <div class="d-flex align-items-start mb-3">
                            <img src="{{asset('assets/web/images/findus/location.png')}}" class="me-3">
                            <div class="">
                                {!! $daftar_kontak->where('sub_pages_slug', 'kontak-alamat')->value('sub_pages_description') !!}
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <img src="{{asset('assets/web/images/findus/call.png')}}" class="me-3">
                            <div class="">
                                {!! $daftar_kontak->where('sub_pages_slug', 'kontak-telepon')->value('sub_pages_description') !!}
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <img src="{{asset('assets/web/images/findus/message.png')}}" class="me-3">
                            <div class="">
                                {!! $daftar_kontak->where('sub_pages_slug', 'kontak-email')->value('sub_pages_description') !!}
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <img src="{{asset('assets/web/images/findus/printer.png')}}" class="me-3">
                            <div class="">
                                {!! $daftar_kontak->where('sub_pages_slug', 'kontak-fax')->value('sub_pages_description') !!}
                            </div>
                        </div>
                        <hr class="mt-5 mb-4 pt-2 pb-2">
                        @if ($code == 'id')
                            <h4 class="fw-bold mb-4">Toko Online</h4>
                        @elseif($code == 'ar')
                            <h4 class="fw-bold mb-4">المتجر الإلكتروني</h4>
                        @elseif($code == 'vi')
                            <h4 class="fw-bold mb-4">Cửa Hàng Trực Tuyến</h4>
                        @else
                            <h4 class="fw-bold mb-4">Online Store</h4>
                        @endif
                        <div class="d-flex align-items-center olshop">
                            @if ($socialmedia->lazada)
                                <a class="me-3" href="{{ $socialmedia->lazada }}"><img
                                        src="{{ asset('assets/web/images/findus/lazada.png') }}"></a>
                            @endif
                            @if ($socialmedia->tiktok)
                                <a class="me-3" href="{{ $socialmedia->tiktok }}"><img
                                        src="{{ asset('assets/web/images/findus/tiktok.png') }}"></a>
                            @endif
                            @if ($socialmedia->tokopedia)
                                <a class="me-3" href="{{ $socialmedia->tokopedia }}"><img
                                        src="{{ asset('assets/web/images/findus/tokopedia.png') }}"></a>
                            @endif
                            @if ($socialmedia->shopee)
                                <a class="me-3" href="{{ $socialmedia->shopee }}"><img
                                        src="{{ asset('assets/web/images/findus/shopee.png') }}"></a>
                            @endif
                        </div>
                        <hr class="mt-5 mb-4 pt-2 pb-2 d-sm-none">
                    </div>
                    <div class="col-12 col-sm-7">
                        <form action="" method="post" id="question-message" class="form-validate">
                            @csrf
                            @if ($section->where('sub_pages_slug', 'bagian-dua')->value('sub_pages_description'))
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
                            @if($code == 'id')
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label fw-bold mb-1">Nama</label>
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label fw-bold mb-1">Email</label>
                                    <input type="email" class="form-control" name="email" id="email">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="phone" class="form-label fw-bold mb-1">Telepon</label>
                                    <input type="text" class="form-control" name="phone" id="phone">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="message" class="form-label fw-bold mb-1">Pesan</label>
                                    <textarea rows="5" class="form-control" name="message" id="message"></textarea>
                                </div>
                                <button href="#" class="btn btn-primary px-5 more filled-button">Kirim</button>
                            @elseif($code == 'ar')
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label fw-bold mb-1">الاسم</label>
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label fw-bold mb-1">البريد الإلكتروني</label>
                                    <input type="email" class="form-control" name="email" id="email">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="phone" class="form-label fw-bold mb-1">الهاتف</label>
                                    <input type="text" class="form-control" name="phone" id="phone">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="message" class="form-label fw-bold mb-1">الرسالة</label>
                                    <textarea rows="5" class="form-control" name="message" id="message"></textarea>
                                </div>
                                <button href="#" class="btn btn-primary px-5 more filled-button">إرسال</button>
                            @elseif($code == 'vi')
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label fw-bold mb-1">Tên</label>
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label fw-bold mb-1">Email</label>
                                    <input type="email" class="form-control" name="email" id="email">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="phone" class="form-label fw-bold mb-1">Số Điện Thoại</label>
                                    <input type="text" class="form-control" name="phone" id="phone">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="message" class="form-label fw-bold mb-1">Tin Nhắn</label>
                                    <textarea rows="5" class="form-control" name="message" id="message"></textarea>
                                </div>
                                <button href="#" class="btn btn-primary px-5 more filled-button">Gửi</button>
                            @else
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label fw-bold mb-1">Name</label>
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label fw-bold mb-1">Email</label>
                                    <input type="email" class="form-control" name="email" id="email">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="phone" class="form-label fw-bold mb-1">Phone</label>
                                    <input type="text" class="form-control" name="phone" id="phone">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="message" class="form-label fw-bold mb-1">Message</label>
                                    <textarea rows="5" class="form-control" name="message" id="message"></textarea>
                                </div>
                                <button href="#" class="btn btn-primary px-5 more filled-button">Submit</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </section>
        @include('web.layouts.cta-footer')
    </main>
    <x-slot name="script">
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', () => {
                document.getElementById('question-message').addEventListener('submit', (e) => {
                    e.preventDefault();
                    const data = $("#question-message").serialize();
                    // console.log(form)
                    $.ajax({
                        url: '/web-question',
                        type: "POST",
                        data: data,
                        success: (data) => {
                            if (data.message) {
                                window.location.reload();
                            } else if (data.error) {
                                alert(data.error);
                            }
                        },
                        error: (data) => {
                            alert(data.responseJSON.errors.message);
                        },
                    });
                })
            })
        </script>
    </x-slot>
</x-web-layout>
<x-web-layout>
    <x-slot name="head"></x-slot>

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="pt-0 hero-category mt-md-0" data-aos="fade-in">
        <div class="hero-img">
            @if (isset($catalog_image))
            <img src="{{ asset('data/banner') . '/' . $catalog_image }}?v=1" class="img-fluid" alt="Hero Desawa">
            @else
            <img src="{{ asset('assets/web/images/catalog/hero-dewasa.jpg') }}" class="img-fluid" alt="Hero Desawa">
            @endif
        </div>
    </section><!-- End Hero -->
    <main id="main">
        <!-- ======= Article ======= -->
        <section id="catalog-wrapper" class="catalog-wrapper">
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="catalog-list row">
                            @if($products->isEmpty())
                            @if($code == 'id')
                                <div class="text-center">Produk belum tersedia</div>
                            @elseif($code == 'ar')
                                <div class="text-center">المنتجات غير متاحة بعد</div>
                            @elseif($code == 'vi')
                                <div class="text-center">Sản phẩm chưa có sẵn</div>
                            @else
                                <div class="text-center">Products are not available yet</div>
                            @endif
                            @else
                            @foreach ($products as $value)
                            <div class="col-12 col-md-3">
                                <div class="catalog-thumbnail">
                                    <a href="#">
                                        <div class="image-catalog"><img src="{{ asset('data/product') . '/' . $value->product_id . '/' . $value->product_image }}"></div>
                                        <div class="content-catalog">
                                            <div class="title-catalog">
                                                <h4>{{ $value->product_title }}</h4>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="{{ route('web.products', ['code' => $code, 'category_title' => $value->category_slug, 'product' => $value->product_slug]) }}" class="btn btn-primary btn-dewasa btn-more">
                                    @if ($code == 'id')
                                        Lihat Produk
                                    @elseif ($code == 'ar')
                                        انظر المنتجات
                                    @elseif ($code == 'vi')
                                        Xem Sản Phẩm
                                    @else
                                        See Product
                                    @endif
                                    </a>
                                </div>
                            </div>
                            @endforeach
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
<x-web-layout>
    <x-slot name="head"></x-slot>

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="pt-0 hero-category mt-md-0" data-aos="fade-in">
        <div class="hero-img">
            @switch($segment)
            @case(1)
            <img src="{{ asset('assets/web/images/catalog/hero-dewasa.jpg') }}" class="img-fluid" alt="Hero Desawa">
            @break
            @case(2)
            <img src="{{ asset('assets/web/images/catalog/hero-remaja.jpg') }}" class="img-fluid" alt="Hero Desawa">
            @break
            @case(3)
            <img src="{{ asset('assets/web/images/catalog/hero-anak.jpg') }}?v=1" class="img-fluid" alt="Hero Desawa">
            @break

            @default

            @endswitch
        </div>
    </section><!-- End Hero -->
    <main id="main">
        <!-- ======= Article ======= -->
        <section id="catalog-wrapper" class="catalog-wrapper">
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="catalog-list row">
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
                                    <a href="catalog-detail.php" class="btn btn-primary btn-dewasa btn-more">Lihat Produk</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="resep" class="resep pt-0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @if(!$products->isEmpty())
                        <h2>Resep dengan produk Nata De Coco ??? {{$products[0]->product_title}}</h2>
                        @else
                        <h2>Resep dengan produk Nata De Coco ???</h2>
                        @endif
                    </div>
                    @foreach ($recipes as $value)
                    <div class="col-sm-4 col-md-3">
                        <div class="recipe-catalog">
                            <a href="recipe-detail.php">
                                <div class="image-resicipe-catalog"><img src="{{ asset('data/recipe/') }}/{{$value->recipe_image}}"></div>
                                <div class="title-recipe-catalog">{{$value->recipe_title}}</div>
                            </a>
                        </div>
                    </div>
                    <!-- set sm-8 md-9 dst, susah -->
                    @endforeach
                </div>
            </div>
        </section>
        @include('web.layouts.cta-footer')
    </main>
    <x-slot name="script"></x-slot>
</x-web-layout>
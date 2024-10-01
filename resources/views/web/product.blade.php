<x-web-layout>
    <x-slot name="head"></x-slot>
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="pt-0" data-aos="fade-in">
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-5 pe-md-5 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                    <h1 class="">Produk</h1>
                </div>
            </div>
        </div>
        <div class="hero-img">
            <img src="{{ asset('assets/web/images/recipe/recipe-hero.jpg') }}" class="img-fluid" alt="Artikel Inaco">
        </div>

    </section><!-- End Hero -->

    <main id="main">

        <!-- ======= Article ======= -->
        <section id="article" class="article">
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">
                    <div class="col-12">
                        @if($category->isEmpty() && $products->isEmpty())
                        <div class="text-center">Konten belum tersedia</div>
                        @else
                        <div class="filter-container text-center mb-5">
                            @if ($category->isNotEmpty())
                            <a href="{{ route('web.products', ['code' => $code]) }}" class="filter-button {{ $category_id ? '' : 'active' }}">Semua</a>
                            @foreach ($category as $value)
                            <a href="{{ route('web.products', ['code' => $code]) }}?currentPage={{ $products->currentPage() }}&category={{ $value->category_slug }}" class="filter-button {{ $value->category_slug == $category_id ? 'active' : '' }}">
                                {{ $value->category_title }}
                            </a>
                            @endforeach
                            @endif
                        </div>
                        @endif
                        <div class="recipe-list row">
                            @if($products->isNotEmpty())
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
                                    <a href="{{ route('web.products', ['code' => $code, 'category_title' => $value->category_slug, 'product' => $value->product_slug]) }}" class="btn btn-primary btn-dewasa btn-more">Lihat Produk</a>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="text-center">Produk belum tersedia</div>
                            @endif
                        </div>
                    </div>
                </div>
                @if($products->isNotEmpty())
                <div class="row mt-5 align-items-center">
                    <div class="col-sm-6 text-center text-sm-start">
                        <div class="show-perpage text-sm">Menampilkan 1-{{ $products->count() }} dari {{ $products->total() }} produk</div>
                    </div>
                    @if ($products->lastPage() != 1)
                    <div class="col-sm-6">
                        <nav aria-label="Page navigation article">
                            <ul class="pagination  justify-content-md-end justify-content-center mt-4 mt-md-0">
                                @if($products->currentPage() - 1 != 0)
                                <li class="page-item"><a class="page-link" href="{{ route('web.recipe', ['code' => $code]) }}?currentPage={{ $products->currentPage() - 1 }}">
                                        <
                                            </a>
                                </li>
                                @endif
                                @for ($i = 1; $i <= $products->lastPage(); $i++)
                                    <li class="page-item {{ ($products->currentPage() == $i) ? 'active' : '' }} ">
                                        <a class="page-link" href="{{ route('web.recipe', ['code' => $code]) }}?currentPage={{ $i }}">
                                            {{ $i }}
                                        </a>
                                    </li>
                                    @endfor
                                    @if($products->currentPage() + 1 < $products->lastPage())
                                        <li class="page-item"><a class="page-link" href="{{ route('web.recipe', ['code' => $code]) }}?currentPage={{ $products->currentPage() + 1 }}">></a></li>
                                        @endif
                            </ul>
                        </nav>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </section>
        @include('web.layouts.cta-footer')
    </main>
    <x-slot name="script"></x-slot>
</x-web-layout>
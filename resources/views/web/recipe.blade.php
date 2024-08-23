<x-web-layout>
    <x-slot name="head"></x-slot>
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="pt-0" data-aos="fade-in">
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-5 pe-md-5 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                    <h1 class="">Recipes Inaco</h1>
                    <p class="">Salad, Kue, Minuman dan masih banyak lagi resep yang membuat hidangan lebih enak dengan INACO!</p>
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
                        <div class="filter-container text-center mb-5">
                            <a href="{{route('web.recipe', ['code' => $code])}}" class="filter-button {{ ($product_id) ? '' : 'active' }}">Semua</a>
                            @foreach ($products as $value)
                            <a href="{{ route('web.recipe', ['code' => $code]) }}?currentPage={{ $recipes->currentPage() }}&product_id={{ $value->product_id }}" class="filter-button {{ $value->product_id == $product_id ? 'active' : '' }} ">{{$value->product_title}}</a>
                            @endforeach
                        </div>
                        <div class="recipe-list row">
                            @foreach ($recipes as $value)
                            <div class="col-12 col-md-3">
                                <div class="recipe-thumbnail">
                                    <div class="recipe-image">
                                        <img src="{{ asset('data/recipe/') }}/{{$value->recipe_image}}">
                                    </div>
                                    <div class="recipe-content">
                                        <div class="recipe-title">
                                            <h4>{{$value->recipe_title}}</h4>
                                        </div>
                                        <div class="recipe-summamry">
                                            <p>{{$value->recipe_description}}</p>
                                        </div>
                                        <a href="{{route('web.recipe', ['code' => $code]) . '?title=' . $value->recipe_slug}}" class="btn btn-primary w-100 more filled-button">Lihat Resep</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row mt-5 align-items-center">
                    <div class="col-sm-6 text-center text-sm-start">
                        <div class="show-perpage text-sm">Menampilkan 1-{{ $currentSum }} dari {{ $recipes->total() }} resep</div>
                    </div>
                    <div class="col-sm-6">
                        <nav aria-label="Page navigation article">
                            <ul class="pagination  justify-content-md-end justify-content-center mt-4 mt-md-0">
                                @if($recipes->currentPage() - 1 != 0)
                                <li class="page-item"><a class="page-link" href="{{ route('web.recipe', ['code' => $code]) }}?currentPage={{ $recipes->currentPage() - 1 }}">
                                        <
                                            </a>
                                </li>
                                @endif
                                @for ($i = 1; $i <= $recipes->lastPage(); $i++)
                                    <li class="page-item {{ ($recipes->currentPage() == $i) ? 'active' : '' }} ">
                                        <a class="page-link" href="{{ route('web.recipe', ['code' => $code]) }}?currentPage={{ $i }}">
                                            {{ $i }}
                                        </a>
                                    </li>
                                    @endfor
                                    @if($recipes->currentPage() + 1 < $recipes->lastPage())
                                        <li class="page-item"><a class="page-link" href="{{ route('web.recipe', ['code' => $code]) }}?currentPage={{ $recipes->currentPage() + 1 }}">></a></li>
                                        @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        @include('web.layouts.cta-footer')
    </main>
    <x-slot name="script"></x-slot>
</x-web-layout>
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
            @if ($page)
            <img src="{{ asset('data/pages') . '/' . $page->pages_image }}" class="img-fluid" alt="Artikel Inaco">
            @endif
        </div>

    </section><!-- End Hero -->

    <main id="main">

        <!-- ======= Article ======= -->
        <section id="article" class="article">
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">
                    <div class="col-12">
                        @if($category->isEmpty() && $recipes->isEmpty())
                        <div class="text-center">Konten belum tersedia</div>
                        @endif
                        <div class="filter-container text-center mb-5">
                            @if ( $category->isNotEmpty())
                            <a href="{{ route('web.recipe', ['code' => $code]) }}" class="filter-button {{ $category_id ? '' : 'active' }}">Semua</a>
                            @foreach ($category as $value)
                            <a href="{{ route('web.recipe', ['code' => $code]) }}?currentPage={{ $recipes->currentPage() }}&category={{ $value->category_id }}" class="filter-button {{ $value->category_id == $category_id ? 'active' : '' }}">
                                {{ $value->category_title }}
                            </a>
                            @endforeach
                            @endif
                        </div>
                        <div class="recipe-list row">
                            @if($recipes->isNotEmpty())
                            @foreach ($recipes as $value)
                            <div class="col-12 col-md-3">
                                <div class="recipe-thumbnail">
                                    <div class="recipe-image">
                                        <img src="{{ asset('data/recipe/') }}/{{$value->recipe_id}}/{{$value->recipe_image}}">
                                    </div>
                                    <div class="recipe-content">
                                        <div class="recipe-title">
                                            <h4>{{$value->recipe_title}}</h4>
                                        </div>
                                        <div class="recipe-summamry">
                                            <p>{{$value->recipe_description}}</p>
                                        </div>
                                        <a href="{{route('web.recipe', ['code' => $code, 'title' => $value->recipe_slug])}}" class="btn btn-primary w-100 more filled-button">Lihat Resep</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="text-center">Konten belum tersedia</div>
                            @endif
                        </div>
                    </div>
                </div>
                @if($recipes->isNotEmpty())
                <div class="row mt-5 align-items-center">
                    <div class="col-sm-6 text-center text-sm-start">
                        <div class="show-perpage text-sm">Menampilkan 1-{{ $currentSum }} dari {{ $recipes->total() }} resep</div>
                    </div>
                    @if ($recipes->lastPage() != 1)
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
                    @endif
                </div>
                @endif
            </div>
        </section>
        @include('web.layouts.cta-footer')
    </main>
    <x-slot name="script"></x-slot>
</x-web-layout>
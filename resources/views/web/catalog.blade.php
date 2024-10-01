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
                            @if($products->isEmpty())
                            <div class="text-center">Produk belum tersedia</div>
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
                                    <a href="{{ route('web.products', ['code' => $code, 'category_title' => $value->category_slug, 'product' => $value->product_slug]) }}" class="btn btn-primary btn-dewasa btn-more">Lihat Produk</a>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @if ($cat_title)
        <section id="resep" class="resep pt-0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @if(!$products->isEmpty())
                        <h2>Resep dengan produk {{ $cat_title }}</h2>
                        @else
                        <h2>Belum ada resep dengan produk ini</h2>
                        @endif
                    </div>
                    <div class="col-sm-4 col-md-3">
                        <div class="recipe-catalog">
                            @if(isset($recipes[0]))
                            <a href="{{route('web.recipe', ['code' => $code, 'title' => $recipes[0]->recipe_slug])}}">
                                <div class="image-recipe-catalog">
                                    <img src="{{ asset('data/recipe') . '/' .$recipes[0]->recipe_id . '/' . $recipes[0]->recipe_image }}">
                                </div>
                                <div class="title-recipe-catalog">{{ $recipes[0]->recipe_title }}</div>
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-8 col-md-9">
                        <div class="recipe-catalog">
                            @if(isset($recipes[1]))
                            <a href="{{route('web.recipe', ['code' => $code, 'title' => $recipes[1]->recipe_slug])}}">
                                <div class="image-recipe-catalog">
                                    <img src="{{ asset('data/recipe') . '/' .$recipes[1]->recipe_id . '/' . $recipes[1]->recipe_image }}">
                                </div>
                                <div class="title-recipe-catalog">{{ $recipes[1]->recipe_title }}</div>
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="recipe-catalog">
                            @if(isset($recipes[2]))
                            <a href="{{route('web.recipe', ['code' => $code, 'title' => $recipes[2]->recipe_slug])}}">
                                <div class="image-recipe-catalog">
                                    <img src="{{ asset('data/recipe') . '/' .$recipes[2]->recipe_id . '/' . $recipes[2]->recipe_image }}">
                                </div>
                                <div class="title-recipe-catalog">{{ $recipes[2]->recipe_title }}</div>
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="recipe-catalog">
                            @if(isset($recipes[3]))
                            <a href="{{route('web.recipe', ['code' => $code, 'title' => $recipes[3]->recipe_slug])}}">
                                <div class="image-recipe-catalog">
                                    <img src="{{ asset('data/recipe') . '/' .$recipes[3]->recipe_id . '/' . $recipes[3]->recipe_image }}">
                                </div>
                                <div class="title-recipe-catalog">{{ $recipes[3]->recipe_title }}</div>
                            </a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </section>
        @endif

        @include('web.layouts.cta-footer')
    </main>
    <x-slot name="script"></x-slot>
</x-web-layout>
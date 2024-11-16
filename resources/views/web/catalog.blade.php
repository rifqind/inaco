<x-web-layout>
    <x-slot name="head"></x-slot>

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="pt-0 hero-category mt-md-0" data-aos="fade-in">
        <div class="hero-img">
            @if ($catalog_image)
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
        @if ($cat_title)
        <section id="resep" class="resep pt-0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @if(!$products->isEmpty())
                        @if($code == 'id')
                            <h2>Resep dengan produk {{ $cat_title }}</h2>
                        @elseif($code == 'ar')
                            <h2>وصفات باستخدام منتج {{ $cat_title }}</h2>
                        @elseif ($code == 'vi')
                            <h2>Công thức với sản phẩm {{ $cat_title }}</h2>
                        @else
                            <h2>Recipes with {{ $cat_title }}</h2>
                        @endif
                        @else
                        @if ($code == 'id')
                            <h2>Belum ada resep dengan produk ini</h2>
                        @elseif ($code == 'ar')
                            <h2>لا توجد وصفات لهذا المنتج حتى الآن</h2>
                        @elseif ($code == 'vi')
                            <h2>Chưa có công thức nào cho sản phẩm này</h2>
                        @else
                            <h2>No recipes available for this product yet</h2>
                        @endif
                        @endif
                    </div>
                    @if (isset($recipes[0]))
                    <div class="col-sm-6">
                        <div class="recipe-catalog">
                            @if(isset($recipes[0]))
                            <a href="{{route('web.recipe.detail', ['code' => $code, 'title' => $recipes[0]->recipe_slug])}}">
                                <div class="image-recipe-catalog">
                                    <img src="{{ asset('data/recipe') . '/' .$recipes[0]->recipe_id . '/' . $recipes[0]->recipe_image }}">
                                </div>
                                <div class="title-recipe-catalog">{{ $recipes[0]->recipe_title }}</div>
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="recipe-catalog">
                            @if(isset($recipes[1]))
                            <a href="{{route('web.recipe.detail', ['code' => $code, 'title' => $recipes[1]->recipe_slug])}}">
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
                            <a href="{{route('web.recipe.detail', ['code' => $code, 'title' => $recipes[2]->recipe_slug])}}">
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
                            <a href="{{route('web.recipe.detail', ['code' => $code, 'title' => $recipes[3]->recipe_slug])}}">
                                <div class="image-recipe-catalog">
                                    <img src="{{ asset('data/recipe') . '/' .$recipes[3]->recipe_id . '/' . $recipes[3]->recipe_image }}">
                                </div>
                                <div class="title-recipe-catalog">{{ $recipes[3]->recipe_title }}</div>
                            </a>
                            @endif
                        </div>
                    </div>
                    @else
                    @if ($code == 'id')
                        Belum ada resep dengan produk ini
                    @elseif ($code == 'ar')
                        لا توجد وصفات لهذا المنتج حتى الآن
                    @elseif ($code == 'vi')
                        Chưa có công thức nào cho sản phẩm này
                    @else
                        No recipes available for this product yet
                    @endif
                    @endif

                </div>
            </div>
        </section>
        @endif

        @include('web.layouts.cta-footer')
    </main>
    <x-slot name="script"></x-slot>
</x-web-layout>
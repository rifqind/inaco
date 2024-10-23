<x-web-layout>
    <x-slot name="head"></x-slot>
    <main id="main">
        <!-- ======= Detail Resep ======= -->
        <section id="detail-recipe" class="detail-recipe">
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">

                    <div class="col-12 mt-5 mb-4">
                        <a href="{{ route('web.recipe', ['code' => $code]) }}" class="backlink"><i
                                class="bi bi-arrow-left me-2"></i>
                            @if ($code == 'id')
                                Kembali
                            @elseif($code == 'ar')
                                العودة
                            @elseif($code == 'vi')
                                Quay lại
                            @else
                                Back
                            @endif
                        </a>
                    </div>
                    <div class="col-md-8">
                        <div id="sync1" class="owl-carousel owl-theme">
                            @if ($image->isNotEmpty())
                                @foreach ($image as $value)
                                    <div class="item">
                                        <a class="image-event" href="#"><img
                                                src="{{ asset('data/recipe/') }}/{{$value->recipe_id}}/{{$value->image_filename}}"></a>
                                    </div>
                                @endforeach
                            @else
                                @if ($code == 'id')
                                    Gambar tidak ada
                                @elseif ($code == 'ar')
                                    الصورة غير موجودة
                                @elseif ($code == 'vi')
                                    Hình Ảnh Không Có
                                @else
                                    Image Not Available
                                @endif
                            @endif
                        </div>
                        @if ($image->count() < 1)
                            <div id="sync2" class="owl-carousel owl-theme">
                                @foreach ($image as $value)
                                    <div class="item">
                                        <a class="image-event" href="#"><img
                                                src="{{ asset('data/recipe/') }}/{{$value->recipe_id}}/{{$value->image_filename}}"></a>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- <div class="plyr__video-embed position-relative rounded-4" id="player"> 
                            <iframe
                                src="https://www.youtube.com/embed/dQw4w9WgXcQ?rel=0&modestbranding=1&iv_load_policy=3&showinfo=0"
                                allowfullscreen
                                allow="autoplay"
                            ></iframe>
                        </div> -->
                        <h1 class="title-detail-recipe">{{$recipe->recipe_title}}</h1>
                        <div class="info-recipe">{{$recipe->create_date}}</div>
                        <hr />
                        <div class="detail-content-recipe">
                            @if($code == 'id')
                                <h4>Bahan-bahan</h4>
                            @elseif($code == 'ar')
                                <h4>المكونات</h4>
                            @elseif($code == 'vi')
                                <h4>Thành phần</h4>
                            @else
                                <h4>Ingredients</h4>
                            @endif
                            {!! $recipe->ingredient !!}

                            <hr />
                            @if($code == 'id')
                                <h4>Cara Memasak</h4>
                            @elseif($code == 'ar')
                                <h4>طريقة الطهي</h4>
                            @elseif($code == 'vi')
                                <h4>Cách Nấu</h4>
                            @else
                                <h4>Cooking Instructions</h4>
                            @endif

                            {!! $recipe->recipe_description !!}
                            <!-- <a href="" class="btn btn-primary more btn-fill mt-4">Print Resep</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- ======= Recipe ======= -->
        <section id="recipe" class="recipe pt-5 mt-3 mb-0">
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            @if ($code == 'id')
                                <h2 class="recipe-title mb-0"><span>Resep Lainnya</span></h2>
                            @elseif($code == 'ar')
                                <h2 class="recipe-title mb-0"><span>وصفات أخرى</span></h2>
                            @elseif($code == 'vi')
                                <h2 class="recipe-title mb-0"><span>Công Thức Khác</span></h2>
                            @else
                                <h2 class="recipe-title mb-0"><span>Other Recipes</span></h2>
                            @endif
                            <a href="{{ route('web.recipe', ['code' => $code]) }}"
                                class="btn btn-primary more d-none d-md-block">
                                @if ($code == 'id')
                                    Lihat Resep
                                @elseif($code == 'ar')
                                    شاهد الوصفات
                                @elseif($code == 'vi')
                                    Xem Công Thức
                                @else
                                    View Recipes
                                @endif

                            </a>
                        </div>
                        <div class="recipe-list row">
                            @foreach ($recipeList as $value)
                                <div class="col-12 col-md-3">
                                    <div class="recipe-thumbnail">
                                        <div class="recipe-image">
                                            <img
                                                src="{{ asset('data/recipe/') }}/{{$value->recipe_id}}/{{$value->recipe_image}}">
                                        </div>
                                        <div class="recipe-content">
                                            <div class="recipe-title">
                                                <h4>{{$value->recipe_title}}</h4>
                                            </div>
                                            <div class="recipe-summamry">
                                                <p>{{$value->recipe_description}}</p>
                                            </div>
                                            <a href="{{route('web.recipe.detail', ['code' => $code, 'title' => $value->recipe_slug])}}"
                                                class="btn btn-primary w-100 more filled-button">
                                                @if ($code == 'id')
                                                    Lihat Resep
                                                @elseif($code == 'ar')
                                                    شاهد الوصفات
                                                @elseif($code == 'vi')
                                                    Xem Công Thức
                                                @else
                                                    View Recipes
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-12 text-center d-md-none">
                                <a href="#" class="btn btn-primary more">
                                    @if ($code == 'id')
                                        Lihat Resep
                                    @elseif($code == 'ar')
                                        شاهد الوصفات
                                    @elseif($code == 'vi')
                                        Xem Công Thức
                                    @else
                                        View Recipes
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('web.layouts.cta-footer')
    </main>
    <x-slot name="script"></x-slot>
</x-web-layout>
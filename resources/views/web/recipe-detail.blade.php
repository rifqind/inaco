<x-web-layout>
    <x-slot name="head"></x-slot>
    <main id="main">
        <!-- ======= Detail Resep ======= -->
        <section id="detail-recipe" class="detail-recipe">
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">

                    <div class="col-12 mt-5 mb-4">
                        <a href="{{ route('web.recipe', ['code' => $code]) }}" class="backlink"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                    </div>
                    <div class="col-md-8">
                        <div id="sync1" class="owl-carousel owl-theme">
                            @foreach ($image as $value)
                            <div class="item">
                                <a class="image-event" href="#"><img src="{{ asset('data/recipe/') }}/{{$value->recipe_id}}/{{$value->image_filename}}"></a>
                            </div>
                            @endforeach
                        </div>
                        
                        <div id="sync2" class="owl-carousel owl-theme">
                            @foreach ($image as $value)
                            <div class="item">
                                <a class="image-event" href="#"><img src="{{ asset('data/recipe/') }}/{{$value->recipe_id}}/{{$value->image_filename}}"></a>
                            </div>
                            @endforeach
                        </div>

                        <h1 class="title-detail-recipe">{{$recipe->recipe_title}}</h1>
                        <div class="info-recipe">{{$recipe->create_date}}</div>
                        <hr />
                        <div class="detail-content-recipe">
                            <h4>Ingredients</h4>
                            {!! $recipe->ingredient !!}

                            <hr />

                            <h4>Cara Memasak</h4>
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
                            <h2 class="recipe-title mb-0"><span>Resep Lainnya</span></h2>
                            <a href="{{ route('web.recipe', ['code' => $code]) }}" class="btn btn-primary more d-none d-md-block">Lihat Lainnya</a>
                        </div>
                        <div class="recipe-list row">
                            @foreach ($recipeList as $value)
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
                            <div class="col-12 text-center d-md-none">
                                <a href="#" class="btn btn-primary more">Lihat Lainnya</a>
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
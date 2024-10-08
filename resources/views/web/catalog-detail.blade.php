<x-web-layout>
    <x-slot name="head"></x-slot>
    <main id="main">
        <section id="catalog-detail" class="catalog-dewasa mt-5 pb-4">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    @if ($detail)
                        <div class="col-12 mb-4">
                            @if ($code == 'id')
                                <a href="#" id="goback" class="backlink"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                            @elseif ($code == 'ar')
                                <a href="#" id="goback" class="backlink"><i class="bi bi-arrow-left me-2"></i>العودة</a>
                            @else
                                <a href="#" id="goback" class="backlink"><i class="bi bi-arrow-left me-2"></i>Go Back</a>
                            @endif
                        </div>
                        <div class="col-md-7">
                            <div id="image-detail" class="image-catalog-detail mb-4 mb-sm-0">
                                <img
                                    src="{{ asset('data/product') . '/' . $detail->product_id . '/' . $detail->product_image }}">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <h1 class="title-catalog">{{ $detail->product_title }}</h1>
                            <!-- <h2 class="subtitle-catalog">Nata De Coco Bag</h2> -->
                            <div class="detail-catalog">
                                {!! $detail->product_description !!}
                            </div>
                            @if ($code == 'id')
                                <button type="button" class="btn btn-primary button-catalog more btn-fill"
                                    data-bs-toggle="modal" data-bs-target="#buyModal">
                                    Beli Sekarang
                                </button>
                            @elseif($code == 'ar')
                                <button type="button" class="btn btn-primary button-catalog more btn-fill"
                                    data-bs-toggle="modal" data-bs-target="#buyModal">
                                    اشترِ الآن
                                </button>
                            @else
                                <button type="button" class="btn btn-primary button-catalog more btn-fill"
                                    data-bs-toggle="modal" data-bs-target="#buyModal">
                                    Buy Now
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="text-center">
                            @if ($code == 'id')
                                Produk Tidak Ada
                            @elseif($code == 'ar')
                                المنتج غير متوفر
                            @else
                                Product Not Available
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </section>
        <section id="catalog-wrapper" class="catalog-wrapper pb-4">
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="d-flex align-items-center justify-content-between mb-4 pb-4">
                            @if ($code == 'id')
                                <h2>Produk {{ $cat_title }} Lainnya</h2>
                                <a href="{{ route('web.products', ['code' => $code, 'category_title' => $cat_title_for_detail]) }}"
                                    class="btn btn-primary more d-none d-sm-block">Lihat Lainnya</a>
                            @elseif ($code == 'ar')
                                <h2>منتجات {{ $cat_title }} أخرى</h2>
                                <a href="{{ route('web.products', ['code' => $code, 'category_title' => $cat_title_for_detail]) }}"
                                    class="btn btn-primary more d-none d-sm-block">عرض المزيد</a>
                            @else
                                <h2>Other {{ $cat_title }} Products</h2>
                                <a href="{{ route('web.products', ['code' => $code, 'category_title' => $cat_title_for_detail]) }}"
                                    class="btn btn-primary more d-none d-sm-block">View More</a>
                            @endif
                        </div>
                        <div class="catalog-list row">
                            @if($products->isNotEmpty())
                                @foreach ($products as $value)
                                    <div class="col-12 col-md-3">
                                        <div class="catalog-thumbnail">
                                            <a href="#">
                                                <div class="image-catalog">
                                                    <img
                                                        src="{{ asset('data/product') . '/' . $value->product_id . '/' . $value->product_image }}">
                                                </div>
                                                <div class="content-catalog">
                                                    <div class="title-catalog">
                                                        <h4>{{ $value->product_title }}</h4>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="{{ route('web.products', ['code' => $code, 'category_title' => $cat_title_for_detail, 'product' => $value->product_slug]) }}"
                                                class="btn btn-primary btn-dewasa btn-more">
                                                @if ($code == 'id')
                                                    Lihat Produk
                                                @elseif ($code == 'ar')
                                                    انظر المنتجات
                                                @else
                                                    See Product
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="text-center">
                            <a href="{{ route('web.products', ['code' => $code, 'category_title' => $cat_title_for_detail]) }}"
                                class="btn btn-primary more d-sm-none">
                                @if ($code == 'id')
                                    Lihat Lainnya
                                @elseif ($code == 'ar')
                                    عرض المزيد
                                @else
                                    View More
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('web.layouts.cta-footer')
    </main>
    <!-- Modal -->
    <div class="modal fade" id="buyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    @if ($code == 'id')
                        <h5 class="modal-title" id="exampleModalLabel">Beli Sekarang</h5>
                    @elseif ($code == 'ar')
                        <h5 class="modal-title" id="exampleModalLabel">اشتري الآن</h5>
                    @else
                        <h5 class="modal-title" id="exampleModalLabel">Buy Now</h5>
                    @endif
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="shop-images row">
                        @if(isset($detail->product_url_shopee))
                            <div class="col-6">
                                <a href="{{ $detail->product_url_shopee }}"><img
                                        src="{{ asset('assets/web/images/shopee.png') }}"></a>
                            </div>
                        @endif

                        @if(isset($detail->product_url_tokopedia))
                            <div class="col-6">
                                <a href="{{ $detail->product_url_tokopedia }}"><img
                                        src="{{ asset('assets/web/images/tokopedia.png') }}"></a>
                            </div>
                        @endif

                        @if(isset($detail->product_url_lazada))
                            <div class="col-6">
                                <a href="{{ $detail->product_url_lazada }}"><img
                                        src="{{ asset('assets/web/images/lazada.png') }}"></a>
                            </div>
                        @endif

                        @if(isset($detail->product_url_tiktokshop))
                            <div class="col-6">
                                <a href="{{ $detail->product_url_tiktokshop }}"><img
                                        src="{{ asset('assets/web/images/tiktok.png') }}"></a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', () => {
                document.getElementById('goback').addEventListener('click', () => {
                    window.history.back();
                })
            })
        </script>
    </x-slot>
</x-web-layout>
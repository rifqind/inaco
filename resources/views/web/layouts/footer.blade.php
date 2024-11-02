<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-7">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/web/images/logo.png') }}" class="me-4">
                        <div>
                            <h4>Inaco</h4>
                            <p>Jalan Raya Bekasi Tambun KM.39.5, Jatimulya, Kec. Tambun Sel., Kabupaten Bekasi, Jawa
                                Barat 17510</p>
                        </div>
                    </div>
                </div>
                @if($code == 'id')
                    <div class="col-md-2 col-6">
                        <ul>
                            <li><a target="_blank" href="{{ route('web.about', ['code' => $code]) }}">Perusahaan</a></li>
                            <li><a target="_blank" href="#">Produk</a></li>
                            <li><a target="_blank" href="{{ route('web.recipe', ['code' => $code]) }}">Resep</a></li>
                            <li><a target="_blank" href="{{ route('web.distributor', ['code' => $code]) }}">Distributor</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-6 ps-0">
                        <ul>
                            <li><a target="_blank" href="{{ route('web.intermarket', ['code' => $code]) }}">Pasar Internasional</a></li>
                            <li><a target="_blank" href="{{ route('web.news', ['id' => 'articles', 'code' => $code]) }}">Berita</a></li>
                            <li><a target="_blank" href="{{ route('web.careers', ['code' => $code]) }}">Karir</a></li>
                        </ul>
                    </div>
                @elseif ($code == 'vi')
                    <div class="col-md-2 col-6">
                        <ul>
                            <li><a target="_blank" href="{{ route('web.about', ['code' => $code]) }}">Công Ty</a></li>
                            <li><a target="_blank" href="#">Sản Phẩm</a></li>
                            <li><a target="_blank" href="{{ route('web.recipe', ['code' => $code]) }}">Công Thức</a></li>
                            <li><a target="_blank" href="{{ route('web.distributor', ['code' => $code]) }}">Nhà Phân Phối</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-6 ps-0">
                        <ul>
                            <li><a target="_blank" href="{{ route('web.intermarket', ['code' => $code]) }}">Thị Trường Quốc Tế</a></li>
                            <li><a target="_blank" href="{{ route('web.news', ['id' => 'articles', 'code' => $code]) }}">Tin Tức</a></li>
                            <li><a target="_blank" href="{{ route('web.careers', ['code' => $code]) }}">Nghề Nghiệp</a></li>
                        </ul>
                    </div>
                @elseif ($code == 'ar')
                    <div class="col-md-2 col-6">
                        <ul>
                            <li><a target="_blank" href="{{ route('web.about', ['code' => $code]) }}">شركة</a></li>
                            <li><a target="_blank" href="#">المنتجات</a></li>
                            <li><a target="_blank" href="{{ route('web.recipe', ['code' => $code]) }}">الإسقاط</a></li>
                            <li><a target="_blank" href="{{ route('web.distributor', ['code' => $code]) }}">موزعات التوزيع</a></li>
                        </ul>

                    </div>

                    <div class="col-md-3 col-6 ps-0">
                        <ul>
                            <li><a target="_blank" href="{{ route('web.intermarket', ['code' => $code]) }}">السوق الدولية</a></li>
                            <li><a target="_blank" href="{{ route('web.news', ['id' => 'articles', 'code' => $code]) }}">أخبار</a></li>
                            <li><a target="_blank" href="{{ route('web.careers', ['code' => $code]) }}">المهنية</a></li>
                        </ul>
                    </div>
                @else
                    <div class="col-md-2 col-6">
                        <ul>
                            <li><a target="_blank" href="{{ route('web.about', ['code' => $code]) }}">Company</a></li>
                            <li><a target="_blank" href="#">Products</a></li>
                            <li><a target="_blank" href="{{ route('web.recipe', ['code' => $code]) }}">Recipe</a></li>
                            <li><a target="_blank" href="{{ route('web.distributor', ['code' => $code]) }}">Distributors</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-6 ps-0">
                        <ul>
                            <li><a target="_blank" href="{{ route('web.intermarket', ['code' => $code]) }}">International Market</a></li>
                            <li><a target="_blank" href="{{ route('web.news', ['id' => 'articles', 'code' => $code]) }}">News</a></li>
                            <li><a target="_blank" href="{{ route('web.careers', ['code' => $code]) }}">Careers</a></li>
                        </ul>
                    </div>
                @endif

            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-5 ps-md-0 mt-3 mt-md-0">All rights reserved - Inaco © 2024</div>
            </div>
        </div>
    </div>
</footer>
<!-- End Footer -->
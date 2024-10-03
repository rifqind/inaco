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
                            <li><a href="#" id="companyFooter">Perusahaan</a></li>
                            <li><a href="#" id="produkFooter">Produk</a></li>
                            <li><a href="{{ route('web.recipe', ['code' => $code]) }}">Resep</a></li>
                            <li><a href="{{ route('web.distributor', ['code' => $code]) }}">Distributor</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-6 ps-0">
                        <ul>
                            <li><a href="{{ route('web.intermarket', ['code' => $code]) }}">Pasar Internasional</a></li>
                            <li><a href="#" id="newsFooter">Berita</a></li>
                            <li><a href="{{ route('web.careers', ['code' => $code]) }}">Karir</a></li>
                        </ul>
                    </div>
                @elseif ($code == 'vi')
                    <div class="col-md-2 col-6">
                        <ul>
                            <li><a href="#" id="companyFooter">Công Ty</a></li>
                            <li><a href="#" id="produkFooter">Sản Phẩm</a></li>
                            <li><a href="{{ route('web.recipe', ['code' => $code]) }}">Công Thức</a></li>
                            <li><a href="{{ route('web.distributor', ['code' => $code]) }}">Nhà Phân Phối</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-6 ps-0">
                        <ul>
                            <li><a href="{{ route('web.intermarket', ['code' => $code]) }}">Thị Trường Quốc Tế</a></li>
                            <li><a href="#" id="newsFooter">Tin Tức</a></li>
                            <li><a href="{{ route('web.careers', ['code' => $code]) }}">Nghề Nghiệp</a></li>
                        </ul>
                    </div>
                @elseif ($code == 'ar')
                    <div class="col-md-2 col-6">
                        <ul>
                            <li><a href="#" id="companyFooter">شركة</a></li>
                            <li><a href="#" id="produkFooter">المنتجات</a></li>
                            <li><a href="{{ route('web.recipe', ['code' => $code]) }}">الإسقاط</a></li>
                            <li><a href="{{ route('web.distributor', ['code' => $code]) }}">موزعات التوزيع</a></li>
                        </ul>

                    </div>

                    <div class="col-md-3 col-6 ps-0">
                        <ul>
                            <li><a href="{{ route('web.intermarket', ['code' => $code]) }}">السوق الدولية</a></li>
                            <li><a href="#" id="newsFooter">أخبار</a></li>
                            <li><a href="{{ route('web.careers', ['code' => $code]) }}">المهنية</a></li>
                        </ul>
                    </div>
                @else
                    <div class="col-md-2 col-6">
                        <ul>
                            <li><a href="#" id="companyFooter">Company</a></li>
                            <li><a href="#" id="produkFooter">Products</a></li>
                            <li><a href="{{ route('web.recipe', ['code' => $code]) }}">Recipe</a></li>
                            <li><a href="{{ route('web.distributor', ['code' => $code]) }}">Distributors</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-6 ps-0">
                        <ul>
                            <li><a href="{{ route('web.intermarket', ['code' => $code]) }}">International Market</a></li>
                            <li><a href="#" id="newsFooter">News</a></li>
                            <li><a href="{{ route('web.careers', ['code' => $code]) }}">Careers</a></li>
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
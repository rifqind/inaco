<x-web-layout>
    <x-slot name="head"></x-slot>
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="pt-0" data-aos="fade-in">
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-5 pe-md-5 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                    @if($code == 'ar')
                    <h1>حول إناكو</h1>
                    <p>قم بالتمرير لأسفل لمعرفة المزيد من التاريخ حول INACO</p>
                    @else
                    @if($descriptions)
                    {!! $descriptions->sub_pages_description !!}
                    @else
                    <div class="text-center">Konten belum tersedia</div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="hero-img">
            @if ($page)
            <img src="{{ asset('data/pages') . '/' . $page->pages_image }}" class="img-fluid" alt="Tentang Inaco">
            @endif
        </div>
    </section>
    <!-- End Hero -->
    <main id="main">
        @if ($code =='ar')
        <!-- ======= About ======= -->
        <section id="about-us" class="about-us">
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">
                    <div class="col-md-9 position-relative">
                        <div class="carousel-container">
                            <div class="carousel slide1">
                                <div class="carousel-item">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-4 image-history pe-md-0"><img src="{{ asset('assets/web/images/about/1990.png') }}"></div>
                                        <div class="col-sm-auto pe-md-0 ps-md-0 content-history">
                                            <div class="year-history">
                                                <h2>۱۹۹۰</h2>
                                            </div>
                                            <div class="caption-history">
                                                <p>بدأت Niramas في إنتاج Nata de Coco وتصديرها إلى أسواق اليابان وتايوان</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-4 image-history pe-md-0"><img src="{{ asset('assets/web/images/about/1994.png') }}"></div>
                                        <div class="col-sm-auto pe-md-0 ps-md-0 content-history">
                                            <div class="year-history">
                                                <h2>۱۹۹٤</h2>
                                            </div>
                                            <div class="caption-history">
                                                <p>تم إنتاج NATA DE COCO بالعلامة التجارية INACO، والتي تعني Nata de Coco الإندونيسية</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-4 image-history pe-md-0"><img src="{{ asset('assets/web/images/about/1996.png') }}"></div>
                                        <div class="col-sm-auto pe-md-0 ps-md-0 content-history">
                                            <div class="year-history">
                                                <h2>۱۹۹٦</h2>
                                            </div>
                                            <div class="caption-history">
                                                <p>تم إنتاج منتج JELLY تحت العلامة التجارية INACO</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-4 image-history pe-md-0"><img src="{{ asset('assets/web/images/about/1999.png') }}"></div>
                                        <div class="col-sm-auto pe-md-0 ps-md-0 content-history">
                                            <div class="year-history">
                                                <h2>۱۹۹۹</h2>
                                            </div>
                                            <div class="caption-history">
                                                <p>إطلاق الألوة فيرا</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-4 image-history pe-md-0"><img src="{{ asset('assets/web/images/about/2001.png') }}"></div>
                                        <div class="col-sm-auto pe-md-0 ps-md-0 content-history">
                                            <div class="year-history">
                                                <h2>۲۰۰۱</h2>
                                            </div>
                                            <div class="caption-history">
                                                <p>ابتكرت منتجًا غذائيًا وظيفيًا فريدًا يحمل الاسم التجاري YOGJELL</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-4 image-history pe-md-0"><img src="{{ asset('assets/web/images/about/2002.png') }}"></div>
                                        <div class="col-sm-auto pe-md-0 ps-md-0 content-history">
                                            <div class="year-history">
                                                <h2>۲۰۰۲</h2>
                                            </div>
                                            <div class="caption-history">
                                                <p>دخلت السوق المتوسطة المنخفضة بعلامة تجارية جديدة للجيلي تسمى YOI</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-4 image-history pe-md-0"><img src="{{ asset('assets/web/images/about/2004.png') }}"></div>
                                        <div class="col-sm-auto pe-md-0 ps-md-0 content-history">
                                            <div class="year-history">
                                                <h2>۲۰۰٤</h2>
                                            </div>
                                            <div class="caption-history">
                                                <p>تم إطلاق العلامة التجارية JELLY بأسعار معقولة مع العلامة التجارية OK TOYS</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-4 image-history pe-md-0"><img src="{{ asset('assets/web/images/about/2006.png') }}"></div>
                                        <div class="col-sm-auto pe-md-0 ps-md-0 content-history">
                                            <div class="year-history">
                                                <h2>۲۰۰٦</h2>
                                            </div>
                                            <div class="caption-history">
                                                <p>تجديد الشعار والتصميم</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-4 image-history pe-md-0"><img src="{{ asset('assets/web/images/about/2010.png') }}"></div>
                                        <div class="col-sm-auto pe-md-0 ps-md-0 content-history">
                                            <div class="year-history">
                                                <h2>۲۰۱۰</h2>
                                            </div>
                                            <div class="caption-history">
                                                <p>مسحوق بودنغ إناكو</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-4 image-history pe-md-0"><img src="{{ asset('assets/web/images/about/2012.png') }}"></div>
                                        <div class="col-sm-auto pe-md-0 ps-md-0 content-history">
                                            <div class="year-history">
                                                <h2>۲۰۱۲</h2>
                                            </div>
                                            <div class="caption-history">
                                                <p>كوب بودنج بثلاث نكهات، باشن فروت، مانجو، قلقاس</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-4 image-history pe-md-0"><img src="{{ asset('assets/web/images/about/2015.png') }}"></div>
                                        <div class="col-sm-auto pe-md-0 ps-md-0 content-history">
                                            <div class="year-history">
                                                <h2>۲۰۱٥</h2>
                                            </div>
                                            <div class="caption-history">
                                                <p>إطلاق مشروب I'M COCO وNata</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="carousel slide2">
                                <div class="carousel-item"><span class="dot-caraousel"></span><span class="year-dot">۱۹۹۰</span></div>
                                <div class="carousel-item"><span class="dot-caraousel"></span><span class="year-dot">۱۹۹٤</span></div>
                                <div class="carousel-item"><span class="dot-caraousel"></span><span class="year-dot">۱۹۹٦</span></div>
                                <div class="carousel-item"><span class="dot-caraousel"></span><span class="year-dot">۱۹۹۹</span></div>
                                <div class="carousel-item"><span class="dot-caraousel"></span><span class="year-dot">۲۰۰۱</span></div>
                                <div class="carousel-item"><span class="dot-caraousel"></span><span class="year-dot">۲۰۰۲</span></div>
                                <div class="carousel-item"><span class="dot-caraousel"></span><span class="year-dot">۲۰۰٤</span></div>
                                <div class="carousel-item"><span class="dot-caraousel"></span><span class="year-dot">۲۰۰٦</span></div>
                                <div class="carousel-item"><span class="dot-caraousel"></span><span class="year-dot">۲۰۱۰</span></div>
                                <div class="carousel-item"><span class="dot-caraousel"></span><span class="year-dot">۲۰۱۲</span></div>
                                <div class="carousel-item"><span class="dot-caraousel"></span><span class="year-dot">۲۰۱٥</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-11 mt-5">
                        <p>تأسست شركة PT Niramas Utama في عام ۱۹۹۰، وتقوم بتصنيع المنتجات تحت علامتها التجارية INACO. حزب العمال. تنتج شركة Niramas Utama مجموعة واسعة من المنتجات عالية الجودة المعتمدة على جوز الهند، من ناتا دي كوكو، والجيلي، ومشروبات ناتا وما إلى ذلك. تنتج شركة PT Niramas Utama أيضًا أحد الأطعمة الفائقة في المستقبل، وهي Aloe VEra وPalm Seed. بصرف النظر عن احتساب نظام تنفيذ GMP في عملياته، فإن PT Niramas Utama مرتبط أيضًا بالمصالح المجتمعية والاجتماعية. نحن نعمل على تمكين السكان المحليين والمزارعين والمناطق المحيطة بها، من خلال خلق التآزر لكل من الشركة وأصحاب المصلحة من خلال التعليم المستمر، وأنشطة المسؤولية الاجتماعية للشركات، واستيعاب الموارد المحلية والمزيد.</p>
                        <p>كان الدخول الأولي لشركة INACO إلى سوق ناتا دي كوكو من خلال شبكة التصدير الخاصة بها، حيث قامت بتوريد منتجاتها إلى اليابان وتايوان. إنها ليست مهمة سهلة أبدًا مع العلم أن الفلبين باعتبارها المنتج الرائد في السوق لـ Nata de Coco قد أنشأت بالفعل شبكات في جميع أنحاء البلاد. بفضل منتجاتها عالية الجودة والتزامها ومثابرتها، تمكنت إناكو من تلبية أعلى المعايير العالمية لتصبح قصة نجاح في السوق العالمية. في أوائل التسعينيات، تمكنت شركة INACO من اقتحام أسواق أستراليا وكندا وماليزيا والإمارات العربية المتحدة وسنغافورة والولايات المتحدة الأمريكية. وبفضل خبرتها الطويلة والمثبتة في السوق العالمية، دخلت شركة INACO السوق الإندونيسية في عام ۱۹۹٦ وحافظت باستمرار على مكانتها كشركة رائدة في السوق في فئة الأغذية الصحية.</p>
                        <p>تفتخر شركة PT Niramas Utama بجوائزها محليًا وعالميًا، مثل أفضل منتج خلال مؤتمر ASEAN للأغذية لعام ۲۰۰۳، والشارة الذهبية لأفضل علامة تجارية في إندونيسيا من مجلة SWA، وجوائز أفضل العلامات التجارية من مجلة التسويق في عام ۲۰۱۲ إلى عام ۲۰۱٦، وOCI (الابتكار المؤسسي المتميز) لعام ۲۰۱٦. لقد أصبحت .INACO الآن علامة تجارية موثوق بها من قبل الشعب الإندونيسي، وفي جميع أنحاء العالم.</p>
                    </div>
                </div>
            </div>
        </section>
        @else
        <!-- ======= About ======= -->
        <section id="about-us" class="about-us">
            <div class="container" data-aos="fade-up">
                <div class="row justify-content-center">
                    <div class="col-md-9 position-relative">
                        <div class="carousel-container">
                            <div class="carousel slide1">
                                @if ($list_year->isNotEmpty())
                                @foreach ($list_year as $value)
                                <div class="carousel-item">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-4 image-history pe-md-0"><img src="{{ asset('data/subpages') . '/' .$value->sub_pages_image }}"></div>
                                        <div class="col-sm-auto pe-md-0 ps-md-0 content-history">
                                            <div class="year-history">
                                                <h2>{{$value->sub_pages_title}}</h2>
                                            </div>
                                            <div class="caption-history">
                                                {!! $value->sub_pages_description !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="text-center">Konten belum tersedia</div>
                                @endif
                            </div>

                            <div class="carousel slide2">
                                @if ($list_year->isNotEmpty())
                                @foreach ($list_year as $value)
                                <div class="carousel-item"><span class="dot-caraousel"></span><span class="year-dot">{{ $value->sub_pages_title }}</span></div>
                                @endforeach
                                @else
                                <div class="text-center">Konten belum tersedia</div>
                                @endif
                            </div>
                        </div>
                        <div id="about-slide" class="owl-carousel owl-theme d-none">
                            @if ($list_year->isNotEmpty())
                            @foreach ($list_year as $value)
                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-sm-4 image-history pe-md-0"><img src="{{ asset('data/subpages') . '/' .$value->sub_pages_image }}"></div>
                                    <div class="col-sm-auto pe-md-0 ps-md-0 content-history">
                                        <div class="year-history">
                                            <h2>{{$value->sub_pages_title}}</h2>
                                        </div>
                                        <div class="caption-history">
                                            {!! $value->sub_pages_description !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="text-center">Konten belum tersedia</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-11 mt-5">
                        @if ($page)
                        {!! $page->pages_description !!}
                        @else
                        <div class="text-center">Konten belum tersedia</div>s
                        @endif
                    </div>
                </div>
            </div>
        </section>
        @endif
        @include('web.layouts.cta-footer')
    </main>
    <x-slot name="script"></x-slot>
</x-web-layout>
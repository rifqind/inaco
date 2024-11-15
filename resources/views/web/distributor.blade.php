<x-web-layout>
    <x-slot name="head"></x-slot>
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="pt-0 text-white" data-aos="fade-in">
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-5 pe-md-5 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
                    data-aos="fade-up" data-aos-delay="200">
                    @if ($section->isNotEmpty())
                    {!! $section->where('sub_pages_slug', 'bagian-satu')->value('sub_pages_description') !!}
                    @else
                    @if ($code == 'id')
                    <div class="text-center">Konten belum tersedia</div>
                    @elseif ($code == 'ar')
                    <div class="text-center">المحتوى غير متوفر بعد</div>
                    @elseif ($code == 'vi')
                    <div class="text-center">Nội dung chưa có sẵn</div>
                    @else
                    <div class="text-center">Content not available</div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="hero-img">
            @if ($page)
            <img src="{{ asset('data/pages') . '/' . $page->pages_image }}" class="img-fluid" alt="Artikel Inaco">
            @else
            <img src="{{ asset('assets/web/images/distributor/distributor-hero.jpg') }}" class="img-fluid"
                alt="Artikel Inaco">
            @endif
        </div>

    </section><!-- End Hero -->

    <main id="main">
        <!-- ======= market ======= -->
        <section id="distributor" class="distributor">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="text-center mb-4" data-aos="fade-up">
                            <div id="chartdistributor" style="width: 100%; height: 600px;"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-7 text-center">
                        @if ($section->isNotEmpty())
                        {!! $section->where('sub_pages_slug', 'bagian-dua')->value('sub_pages_description') !!}
                        @else
                        @if ($code == 'id')
                        <div class="text-center">Konten belum tersedia</div>
                        @elseif ($code == 'ar')
                        <div class="text-center">المحتوى غير متوفر بعد</div>
                        @elseif ($code == 'vi')
                        <div class="text-center">Nội dung chưa có sẵn</div>
                        @else
                        <div class="text-center">Content not available</div>
                        @endif
                        @endif
                    </div>
                </div>
                <div class="row text-center mt-4">
                    <div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
                        @foreach ($distributor as $value)
                        <div class="list-market"> {{ strtoupper($value->province_name) }}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @include('web.layouts.cta-footer')
        <x-slot name="script">
            <script>
                var province = {{ Js::from($indonesiaISO) }}
                am5.ready(function() {

                    // Create root element
                    var root = am5.Root.new("chartdistributor");

                    // Set themes
                    root.setThemes([
                        am5themes_Animated.new(root)
                    ]);

                    // Create chart
                    var chart = root.container.children.push(am5map.MapChart.new(root, {
                        panX: "none", // Disable panning
                        panY: "none", // Disable panning
                        wheelY: "none", // Disable zooming
                        projection: am5map.geoMercator()
                    }));

                    // Create main polygon series for countries
                    var polygonSeries = chart.series.push(am5map.MapPolygonSeries.new(root, {
                        geoJSON: am5geodata_indonesiaLow,
                    }));

                    polygonSeries.mapPolygons.template.setAll({
                        interactive: true,
                        fill: am5.color(0xaaaaaa) // default color: grey
                    });

                    polygonSeries.mapPolygons.template.states.create("active", {
                        fill: am5.color('#E20A19') // active color: red
                    });

                    polygonSeries.mapPolygons.template.events.on("pointerover", function(ev) {
                        if (province.indexOf(ev.target.dataItem.get("id")) === -1) {
                            ev.target.set("tooltipText", null);
                        } else {
                            ev.target.set("tooltipText", "{name}");
                        }
                    });

                    // Set active countries
                    polygonSeries.events.on("datavalidated", function() {
                        polygonSeries.mapPolygons.each(function(polygon) {
                            if (province.indexOf(polygon.dataItem.get("id")) !== -1) {
                                polygon.states.applyAnimate("active");
                            }
                        });
                    });

                    // Make stuff animate on load
                    chart.appear(1000, 100);


                }); // end am5.ready() 
            </script>
        </x-slot>
</x-web-layout>
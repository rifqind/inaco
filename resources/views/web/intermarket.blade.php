<x-web-layout>
    <x-slot name="head"></x-slot>
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="pt-0 text-white" data-aos="fade-in">
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
        <!-- ======= market ======= -->
        <section id="market" class="market">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="text-center mb-4" data-aos="fade-up">
                            <div id="chartmarket"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-7 text-center">
                        @if ($section->isNotEmpty())
                        {!! $section->where('sub_pages_slug', 'bagian-dua')->value('sub_pages_description') !!}
                        @else
                        <div class="text-center">Konten belum tersedia</div>
                        @endif
                    </div>
                </div>
                <div class="row text-center mt-4">
                    @if($northAmerica->isNotEmpty())
                    <div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
                        <h3>NORTH AMERICA</h3>
                        @foreach ($northAmerica as $value)
                        <div class="list-market"> {{ $value->name }} </div>
                        @endforeach
                    </div>
                    @endif
                    @if($southAmerica->isNotEmpty())
                    <div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
                        <h3>SOUTH AMERICA</h3>
                        @foreach ($southAmerica as $value)
                        <div class="list-market"> {{ $value->name }} </div>
                        @endforeach
                    </div>
                    @endif
                    @if($europe->isNotEmpty())
                    <div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
                        <h3>EUROPE</h3>
                        @foreach ($europe as $value)
                        <div class="list-market"> {{ $value->name }} </div>
                        @endforeach
                    </div>
                    @endif
                    @if($africa->isNotEmpty())
                    <div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
                        <h3>AFRICA</h3>
                        @foreach ($africa as $value)
                        <div class="list-market"> {{ $value->name }} </div>
                        @endforeach
                    </div>
                    @endif
                    @if($asia->isNotEmpty())
                    <div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
                        <h3>ASIA</h3>
                        @foreach ($asia as $value)
                        <div class="list-market"> {{ $value->name }} </div>
                        @endforeach
                    </div>
                    @endif
                    @if($oceania->isNotEmpty())
                    <div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
                        <h3>OCEANIA</h3>
                        @foreach ($oceania as $value)
                        <div class="list-market"> {{ $value->name }} </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </section>
        @include('web.layouts.cta-footer')
    </main>

    <x-slot name="script">
        <script>
            var activeCountries = {{Js::from($countryISO)}}
            am5.ready(function() {

                // Create root element
                var root = am5.Root.new("chartmarket");

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
                    geoJSON: am5geodata_worldLow,
                    exclude: ["AQ"] // Exclude Antarctica
                }));

                polygonSeries.mapPolygons.template.setAll({
                    interactive: true,
                    fill: am5.color(0xaaaaaa) // default color: grey
                });

                polygonSeries.mapPolygons.template.states.create("active", {
                    fill: am5.color('#E20A19') // active color: red
                });

                polygonSeries.mapPolygons.template.events.on("pointerover", function(ev) {
                    if (activeCountries.indexOf(ev.target.dataItem.get("id")) === -1) {
                        ev.target.set("tooltipText", null);
                    } else {
                        ev.target.set("tooltipText", "{name}");
                    }
                });

                // Set active countries
                polygonSeries.events.on("datavalidated", function() {
                    polygonSeries.mapPolygons.each(function(polygon) {
                        if (activeCountries.indexOf(polygon.dataItem.get("id")) !== -1) {
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
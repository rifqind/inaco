<x-web-layout>
    <x-slot name="head"></x-slot>
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="pt-0 text-white" data-aos="fade-in">
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-5 pe-md-5 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                    <h1 class="">Temukan kami</h1>
                    <p class="">Produk INACO semakin dekat dan mudah ditemukan oleh pelanggannya.</p>
                </div>
            </div>
        </div>
        <div class="hero-img">
            <img src="{{ asset('assets/web/images/distributor/distributor-hero.jpg') . '?v=1' }}" class="img-fluid" alt="Award Inaco">
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
                        <h2 data-aos="fade-up" class="fw-bold">City List</h2>
                        <p data-aos="fade-up">For more detailed information, we also provide a list of cities where our distributors are located. This list helps you find the closest distributor to your location and get in touch with them directly.
                        </p>
                    </div>
                </div>
                <div class="row text-center mt-4">
                    <div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
                        <h3> SUMATERA </h3>
                        @foreach ($distributor as $value)
                        @if ($value->province_id < 11)
                            <div class="list-market"> {{ strtoupper($value->city_name) }}
                    </div>
                    @endif
                    @endforeach
                </div>

                <div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
                    <h3> DKI JAKARTA </h3>
                    <div class="list-market"> DKI JAKARTA
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
                    <h3> JAWA BARAT </h3>
                    @foreach ($distributor as $value)
                    @if ($value->province_id == 12)
                    <div class="list-market"> {{ strtoupper($value->city_name) }}
                    </div>
                    @endif
                    @endforeach

                </div>
                <div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
                    <h3> JAWA TENGAH </h3>
                    @foreach ($distributor as $value)
                    @if ($value->province_id == 13)
                    <div class="list-market"> {{ strtoupper($value->city_name) }}
                    </div>
                    @endif
                    @endforeach

                </div>
                <div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
                    <h3> JAWA TIMUR </h3>
                    @foreach ($distributor as $value)
                    @if ($value->province_id == 15)
                    <div class="list-market"> {{ strtoupper($value->city_name) }}
                    </div>
                    @endif
                    @endforeach
                </div>
                <div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
                    <h3> BANTEN </h3>
                    @foreach ($distributor as $value)
                    @if ($value->province_id == 16)
                    <div class="list-market"> {{ strtoupper($value->city_name) }}
                    </div>
                    @endif
                    @endforeach
                </div>

                <div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
                    <h3> JAWA BARAT </h3>
                    @foreach ($distributor as $value)
                    @if ($value->province_id == 12)
                    <div class="list-market"> {{ strtoupper($value->city_name) }}
                    </div>
                    @endif
                    @endforeach
                </div>

                <div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
                    <h3> BALI & NUSA TENGGARA </h3>
                    @foreach ($distributor as $value)
                    @if ($value->province_id > 16 && $value->province_id < 20)
                        <div class="list-market"> {{ strtoupper($value->city_name) }}
                </div>
                @endif
                @endforeach
            </div>

            <div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
                <h3> KALIMANTAN </h3>
                @foreach ($distributor as $value)
                @if ($value->province_id > 19 && $value->province_id < 25)
                    <div class="list-market"> {{ strtoupper($value->city_name) }}
            </div>
            @endif
            @endforeach

            </div>


            <div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
                <h3> SULAWESI </h3>
                @foreach ($distributor as $value)
                @if ($value->province_id > 24 && $value->province_id < 31)
                    <div class="list-market"> {{ strtoupper($value->city_name) }}
            </div>
            @endif
            @endforeach
            </div>
            <div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
                <h3> MALUKU & PAPUA </h3>
                @foreach ($distributor as $value)
                @if ($value->province_id > 30 && $value->province_id < 35)
                    <div class="list-market"> {{ strtoupper($value->city_name) }}
            </div>
            @endif
            @endforeach

            </div>
            </div>
            </div>
        </section>
        @include('web.layouts.cta-footer')
        <x-slot name="script">
            <script>
                var cities = {{ Js::from($bigCity) }}
                am5.ready(function() {

                    // Create root element
                    var root = am5.Root.new("chartdistributor");

                    // Set themes
                    root.setThemes([
                        am5themes_Animated.new(root)
                    ]);



                    // Create the map chart
                    var chart = root.container.children.push(
                        am5map.MapChart.new(root, {
                            panX: "none",
                            panY: "none",
                            wheelX: "none",
                            wheelY: "none"
                        })
                    );
                    // Set padding on the chart container
                    chart.set("paddingLeft", 20); // Adjust as needed
                    chart.set("paddingRight", 20); // Adjust as needed

                    // Load Indonesia map
                    var polygonSeries = chart.series.push(
                        am5map.MapPolygonSeries.new(root, {
                            geoJSON: am5geodata_indonesiaLow
                        })
                    );

                    // Set fill and stroke style for polygons (landmasses)
                    polygonSeries.mapPolygons.template.setAll({
                        fill: am5.color(0xdddddd), // Warna daratan peta
                        stroke: am5.color(0xffffff), // Warna batas peta
                        strokeWidth: 2 // Mengatur lebar garis batas menjadi lebih tebal
                    });

                    // Create point series for city markers
                    var pointSeries = chart.series.push(am5map.MapPointSeries.new(root, {
                        valueField: "value",
                        calculateAggregates: true
                    }));

                    // Assign the cities data to the point series
                    pointSeries.data.setAll(cities.map(function(city) {
                        return {
                            geometry: {
                                type: "Point",
                                coordinates: [city.longitude, city.latitude]
                            },
                            title: city.name // Assigning title for each city
                        };
                    }));

                    // Create a custom bullet for the points
                    pointSeries.bullets.push(function(root, series, dataItem) {
                        var container = am5.Container.new(root, {});
                        var image = container.children.push(am5.Picture.new(root, {
                            width: 40,
                            height: 30,
                            centerX: am5.p50,
                            centerY: am5.p100,
                            src: "/assets/web/images/marker.svg", // Pastikan marker.svg berada di path yang benar
                            tooltipText: "{title}" // Bind the tooltip to the correct city name
                        }));


                        // Customize tooltip appearance
                        image.set("tooltip", am5.Tooltip.new(root, {
                            getFillFromSprite: false,
                            getStrokeFromSprite: true,
                            background: am5.Rectangle.new(root, {
                                fill: am5.color(0xdddddd), // Set background color to #ddd
                                stroke: am5.color(0x999999), // Optional: add a border color
                                cornerRadius: 8 // Add rounded corners with 8px radius
                            }),
                            labelText: "{title}" // Set the text to the city's title
                        }));

                        return am5.Bullet.new(root, {
                            sprite: container
                        });
                    });

                    // Make stuff animate on load
                    chart.appear(1000, 100);

                }); // end am5.ready()
            </script>
        </x-slot>
</x-web-layout>
<?php
	include "header.php";
?>



	<!-- ======= Hero Section ======= -->
	<section id="hero" class="pt-0 text-white" data-aos="fade-in">
		<div class="container">
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-5 pe-md-5 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
				  <h1 class="">International Market</h1>
				  <p class="">Expanding Global Horizons by Navigating the Complexities of Global Trade</p>
				</div>
			</div>
		</div>
		<div class="hero-img">
		  <img src="assets/images/market/market-hero.jpg" class="img-fluid" alt="Award Inaco">
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
				<h2 data-aos="fade-up">Geographical Coverage</h2>
				<p data-aos="fade-up">Our international market presence spans multiple regions, each with its own unique opportunities and challenges. Our extensive reach allows us to operate in the following areas:</p>
			</div>
		</div>
		<div class="row text-center mt-4">
			<div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
				<h3>America</h3>
				<div class="list-market">Canada </div>
				<div class="list-market">USA </div>
				<div class="list-market">Trinidad & Tobago </div>
				<div class="list-market">Guyana </div>
				<div class="list-market">Suriname </div>
				<div class="list-market">Peru </div>
			</div>
			<div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
				<h3>Europe</h3>
				<div class="list-market">Netherland </div>
				<div class="list-market">Polandia </div>
				<div class="list-market">Rusia </div>
				<div class="list-market">Prancis</div>
				<div class="list-market">United Kingdom</div>

			</div>
			<div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
				<h3>Middle East</h3>
				<div class="list-market">Palestina </div>
				<div class="list-market">Iraq </div>
				<div class="list-market">Iran </div>
				<div class="list-market">Bahrain </div>
				<div class="list-market">Kuwait </div>
				<div class="list-market">Qatar </div>
				<div class="list-market">Saudi Arabia </div>
			</div>
			<div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
				<h3>Africa</h3>
				<div class="list-market">Somalia </div>
				<div class="list-market">South Africa </div>

			</div>
			<div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
				<h3>Asia</h3>
				<div class="list-market">Pakistan </div>
				<div class="list-market">India </div>
				<div class="list-market">Myanmar </div>
				<div class="list-market">China </div>
				<div class="list-market">South Korea </div>
				<div class="list-market">Hongkong </div>
				<div class="list-market">Japan </div>
				<div class="list-market">Taiwan </div>
				<div class="list-market">Vietnam </div>
				<div class="list-market">Philippines </div>
				<div class="list-market">Brunei Darussalam </div>
				<div class="list-market">Cambodia </div>
				<div class="list-market">Malaysia </div>
				<div class="list-market">Singapore</div>
				<div class="list-market">Timor Leste </div>
			</div>
			<div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
				<h3>Pacific Island</h3>
				<div class="list-market">Papua new guinea </div>
			</div>
			<div class="col-6 col-sm-4 col-md-3 card-market" data-aos="fade-up">
				<h3>Oceania</h3>
				<div class="list-market">Australia </div>
				<div class="list-market">Fiji</div>
			</div>
		</div>
	  </div>
	</section>

	<?php echo $cta_footer; ?>

	<script>
		am5.ready(function() {

		// Create root element
		var root = am5.Root.new("chartmarket");

		// Set themes
		root.setThemes([
			am5themes_Animated.new(root)
		]);

		// Create chart
		var chart = root.container.children.push(am5map.MapChart.new(root, {
			panX: "none",  // Disable panning
			panY: "none",  // Disable panning
			wheelY: "none",  // Disable zooming
			projection: am5map.geoMercator()
		}));

		// Create main polygon series for countries
		var polygonSeries = chart.series.push(am5map.MapPolygonSeries.new(root, {
			geoJSON: am5geodata_worldLow,
			exclude: ["AQ"] // Exclude Antarctica
		}));

		// List of active countries
		var activeCountries = [
			"CA", "US", "TT", "GY", "SR", "PE",
			"NL", "PL", "RU", "FR", "GB", "PS", 
			"IQ", "IR", "BH", "KW", "QA", "SA", 
			"SO", "ZA", "PK", "IN", "MM", "CN", 
			"KR", "HK", "JP", "TW", "VN", "PH", 
			"BN", "KH", "MY", "SG", "TL", "PG", 
			"AU", "FJ"
		];

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

<?php
	include "footer.php";
?>
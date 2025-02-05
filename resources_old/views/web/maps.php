<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>amCharts World Map</title>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
</head>
<body>
    <div id="chartdiv" style="width: 100%; height: 600px;"></div>
    <script>
        am5.ready(function() {

            // Create root element
            var root = am5.Root.new("chartdiv");

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
</body>
</html>

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container" style="text-align: center; margin-top: 10px;">
        <!-- Logo and Description -->
        <img src="{{ asset('img/logo-kpspams.png') }}" style="width: 120px;">
        <p style="font-size: 50px; font-weight: bold; color: white;">PAM SIMAS SAGARA</p>
        <p style="font-size: 20px; font-weight: bold; color: white;">-DESA SINDANGKERTA, KECAMATAN SINDANGKERTA, KABUPATEN
            BANDUNG BARAT, JAWA BARAT-</p>

        <div class="row" style="margin-left: -50px;">
            <!-- Nilai Jarak -->
            <div class="col-md-3">
                <div class="card mb-3" style="height: 150px;">
                    <div class="card-header"
                        style="font-size: 16px; font-weight: bold; background-color: cornflowerblue; color: white;">
                        <h4>Nilai Jarak</h4>
                    </div>
                    <div class="card-body"
                        style="font-size: 24px; font-weight: bold; display: flex; align-items: center; justify-content: center; height: 100%;">
                        <h1><span id="nilai_jarak">0</span> m</h1>
                    </div>
                </div>
            </div>

            <!-- Ketinggian Air -->
            <div class="col-md-3">
                <div class="card mb-3" style="height: 150px;">
                    <div class="card-header"
                        style="font-size: 16px; font-weight: bold; background-color: cornflowerblue; color: white;">
                        <h4>Ketinggian Air Sumur</h4>
                    </div>
                    <div class="card-body"
                        style="font-size: 24px; font-weight: bold; display: flex; align-items: center; justify-content: center; height: 100%;">
                        <h1><span id="ketinggian_air">0</span> m</h1>
                    </div>
                </div>
            </div>

            <!-- Volume Air -->
            <div class="col-md-3">
                <div class="card mb-3" style="height: 150px;">
                    <div class="card-header"
                        style="font-size: 16px; font-weight: bold; background-color: cornflowerblue; color: white;">
                        <h4>Volume Air Sumur</h4>
                    </div>
                    <div class="card-body"
                        style="font-size: 24px; font-weight: bold; display: flex; align-items: center; justify-content: center; height: 100%;">
                        <h1><span id="volume_air">0</span> L</h1>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="col-md-3">
                <div class="card mb-3" style="height: 150px;">
                    <div class="card-header"
                        style="font-size: 16px; font-weight: bold; background-color: cornflowerblue; color: white;">
                        <h4>Status Sumur</h4>
                    </div>
                    <div class="card-body"
                        style="font-size: 10px; font-weight: bold; display: flex; align-items: center; justify-content: center;">
                        <h1 id="STATUS-JARAK">-</h1>
                    </div>
                </div>
            </div>

            <!-- Kekeruhan Air -->
            <div class="col-md-3">
                <div class="card mb-3" style="height: 150px;">
                    <div class="card-header"
                        style="font-size: 16px; font-weight: bold; background-color: cornflowerblue; color: white;">
                        <h4>Kekeruhan Air Sumur</h4>
                    </div>
                    <div class="card-body"
                        style="font-size: 24px; font-weight: bold; display: flex; align-items: center; justify-content: center; height: 100%;">
                        <h1><span id="kekeruhan_air">0</span> NTU</h1>
                    </div>
                </div>
            </div>

            <!-- pH Air -->
            <div class="col-md-3">
                <div class="card mb-3" style="height: 150px;">
                    <div class="card-header"
                        style="font-size: 16px; font-weight: bold; background-color: cornflowerblue; color: white;">
                        <h4>pH Air Sumur</h4>
                    </div>
                    <div class="card-body"
                        style="font-size: 24px; font-weight: bold; display: flex; align-items: center; justify-content: center; height: 100%;">
                        <h1><span id="ph_air">0</span></h1>
                    </div>
                </div>
            </div>

            <!-- Water Usability -->
            <div class="col-md-6">
                <div class="card mb-6" style="height: 150px;">
                    <div class="card-header"
                        style="font-size: 16px; font-weight: bold; background-color: cornflowerblue; color: white;">
                        <h4>Kualitas Air</h4>
                    </div>
                    <div class="card-body"
                        style="font-size: 18px; font-weight: bold; display: flex; align-items: center; justify-content: center; height: 100%;">
                        <h1 id="water_quality_status">-</h1>
                    </div>
                </div>
            </div>

            <!-- Sumur (Well) Visualization -->


        </div>

        <div class="row" style="margin-bottom: 200px; margin-left: -50px">
            <!-- Grafik -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header"
                        style="font-size: 30px; font-weight: bold; background-color: cornflowerblue; color: white;">
                        <h3>Ketinggian Air Sumur</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="waterLevelChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Water Well Animation -->
            <div class="col-md-3">
                <div id="well-container"
                    style="width: 100%; height: 427px; border: 5px solid cornflowerblue; position: relative; background-color: rgb(255, 255, 255);">
                    <!-- Water fill animation -->
                    <div id="water"
                        style="width: 100%; height: 0; background-color: cornflowerblue; position: absolute; bottom: 0; animation: wave 5s ease-in-out infinite;">
                        <!-- Text elements for displaying jarak and ketinggian -->
                    </div>
                </div>
            </div>
        </div>

    </div>
    <style>
        @keyframes wave {
            0% {
                height: 65%;
            }

            50% {
                height: 70%;
            }

            100% {
                height: 65%;
                /* Adjust to be 5% lower than 40% */
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            var lastValue = null;
            var chartData = [];

            // Initialize the chart
            var ctx = document.getElementById('waterLevelChart').getContext('2d');
            var waterLevelChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [], // Time labels will be added dynamically
                    datasets: [{
                        label: 'Ketinggian Air',
                        borderColor: 'cornflowerblue',
                        backgroundColor: 'rgba(100, 149, 237, 0.2)',
                        data: [] // Data values will be added dynamically
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Waktu (WIB)'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Ketinggian Air (meter)'
                            }
                        }
                    }
                }
            });

            // Fetch the initial data
            function fetchData() {
                $.getJSON("api/water-level-data", function(data) {
                    chartData = data.chart_data; // Get the chart data from the API response
                    chartData.forEach(function(entry) {
                        waterLevelChart.data.labels.push(entry.time);
                        waterLevelChart.data.datasets[0].data.push(entry.level);
                    });
                    waterLevelChart.update();
                });
            }

            fetchData();

            // Update data every second
            setInterval(function() {
                $.getJSON("api/water-level-data", function(data) {
                    if (lastValue !== data.level) {
                        $("#nilai_jarak").text(data.level);
                        $("#ketinggian_air").text(84 - data.level);
                        $("#volume_air").text(calculateVolume(84 - data.level));
                        $("#kekeruhan_air").text(data.kekeruhan_air); // Update kekeruhan air
                        $("#ph_air").text(data.ph_air); // Update pH air
                        $("#STATUS-JARAK").text(data.status);
                        lastValue = data.level;
                        updateChart(data);
                        updateWaterLevelAnimation(84 - data
                            .level); // Update the water level animation
                        updateWaterQualityStatus(data.ph_air, data.kekeruhan_air);
                    }
                });
            }, 1000);

            // Function to update the chart
            function updateChart(data) {
                var time = new Date().toLocaleTimeString();
                var level = (84 - data.level);

                chartData.push({
                    time: time,
                    level: level
                });
                if (chartData.length > 15) {
                    chartData.shift();
                }

                waterLevelChart.data.labels = chartData.map(function(entry) {
                    return entry.time;
                });
                waterLevelChart.data.datasets[0].data = chartData.map(function(entry) {
                    return entry.level;
                });
                waterLevelChart.update();
            }

            // Function to update the water level animation
            // Function to update the water level animation
            function updateWaterLevelAnimation(level) {
                var wellHeight = 8500; // Height of the well in pixels
                var maxLevel = 84; // Max height level in meters
                var waterHeight = (level / maxLevel) * wellHeight; // Calculate the water height based on the level
                $("#water").css('height', waterHeight + 'px');
                $("#water-level-value").text(level.toFixed(2)); // Update the ketinggian displayed inside the water
                $("#distance-value").text((84 - level).toFixed(2)); // Update the jarak displayed above the water

                // Determine color based on level
                var color;
                if (level <= 0.40 * maxLevel) { // Safe level
                    color = 'green';
                } else if (level <= 0.60 * maxLevel) { // Warning level
                    color = 'yellow';
                } else { // Danger level
                    color = 'red';
                }

                // Update the water color based on the status
                $("#water").css('background-color', color);
            }


            // Function to calculate volume
            function calculateVolume(height) {
                var radius = 0.075; // 82.5 mm to meters
                var volume = Math.PI * Math.pow(radius, 2) * height; // Volume in cubic meters
                return (volume * 1000).toFixed(2); // Convert to liters and format
            }

            // Function to update water quality status
            function updateWaterQualityStatus(ph_air, kekeruhan_air) {
                let status = "Baik";

                if (ph_air >= 6.5 && ph_air <= 8.5 && kekeruhan_air <= 2) {
                    status = "Baik";
                } else {
                    status = "Tidak Memadai";
                }

                $("#water_quality_status").text(status);
            }
        });
    </script>
@endsection

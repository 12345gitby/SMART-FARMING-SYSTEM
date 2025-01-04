<?php
// Connect to the database
$conn = mysqli_connect('localhost', 'root', 'Jay@2003', 'soilmonitoring');

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Perform a query to fetch the latest 7 records
$query = "SELECT * FROM soil_data ORDER BY id DESC LIMIT 7";
$result = mysqli_query($conn, $query);

// Initialize arrays for sensor data
$humidity_data = [];
$temperature_data = [];
$nitrogen_data = [];
$phosphorus_data = [];
$potassium_data = [];

// Check if the result contains rows
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Store the data into arrays
        $humidity_data[] = (int) $row['humidity'];
        $temperature_data[] = (int) $row['temperature'];
        $nitrogen_data[] = (int) $row['nitrogen'];
        $phosphorus_data[] = (int) $row['phosphorus'];
        $potassium_data[] = (int) $row['potassium'];
    }
    $avg_humidity = array_sum($humidity_data) / count($humidity_data);
    $avg_temperature = array_sum($temperature_data) / count($temperature_data);
    $avg_nitrogen = array_sum($nitrogen_data) / count($nitrogen_data);
    $avg_phosphorus = array_sum($phosphorus_data) / count($phosphorus_data);
    $avg_potassium = array_sum($potassium_data) / count($potassium_data);
} else {
    die("No data found in the database.");
}

// Close the database connection
mysqli_close($conn);

// Reverse the data arrays to maintain ascending order (oldest to newest)
$humidity_data_json = json_encode(array_reverse($humidity_data));
$temperature_data_json = json_encode(array_reverse($temperature_data));
$nitrogen_data_json = json_encode(array_reverse($nitrogen_data));
$phosphorus_data_json = json_encode(array_reverse($phosphorus_data));
$potassium_data_json = json_encode(array_reverse($potassium_data));
// Prepare sensor data to be sent to the Flask API using the calculated averages
$sensor_data = [
    'nitrogen' => $avg_nitrogen,
    'phosphorus' => $avg_phosphorus,
    'potassium' => $avg_potassium,
    'temperature' => $avg_temperature,
    'humidity' => 82.0,                 // Static or example values for humidity, pH, and rainfall
    'ph' => 6.7,
    'rainfall' => 202.2
];
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="png/soilmonitor.png">
    <title>Soil Monitor</title>
    <!-- Custom CSS -->
    <link href="../../assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../../dist/css/style.min.css" rel="stylesheet">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <style>
        body {
            background-image: url('../../png/bg1.png');
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .transparent-container h4.page-title {
            color: #fff;
            font-weight: bolder;
            /* White text */
        }


        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 960px;
            margin: auto;
            margin-top: 20px;
        }

        .card-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        #container {
            width: 100%;
            height: 400px;
            /* Set height for the chart */
        }


        .left-sidebar {
            /* width: 250px; */
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            background-color: #343a40;
            /* Custom sidebar color */
            padding-top: 60px;
            z-index: 100;
        }

        .main-content {
            margin-left: 250px;
            /* Same width as the sidebar */
            padding: 20px;
        }

        @media (max-width: 768px) {
            .left-sidebar {
                width: 100%;
                position: relative;
            }

            .main-content {
                margin-left: 0;
            }
        }

        .transparent-container {
            background-color: rgba(255, 255, 255, 0.8);
            /* Semi-transparent background */
        }

        .switches {
            display: flex;
            gap: 4px;
            margin-top: 20px;
        }

        .switch {
            border-radius: 6px;
            padding: 8px 16px;
            cursor: pointer;
            background-color: #f0f0f0;
            transition: all 0.3s ease;
            border: 1px solid #ddd;
            font-weight: 500;
            color: #666;
        }

        .switch:hover {
            background-color: #e0e0e0;
        }

        .switch.active {
            background-color: #137EFF;
            color: white;
            border-color: #137EFF;
            box-shadow: 0 2px 4px rgba(19, 126, 255, 0.2);
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-navbarbg="skin6" data-theme="light" data-layout="vertical" data-sidebartype="full"
        data-boxed-layout="full">
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header" data-logobg="skin5">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="ti-menu ti-close"></i>
                    </a>
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti-more"></i>
                    </a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin6">
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item search-box">
                            <a class="nav-link waves-effect waves-dark" href="javascript:void(0)">
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-magnify font-20 mr-1"></i>
                                    <div class="ml-1 d-none d-sm-block">
                                        <span>Search</span>
                                    </div>
                                </div>
                            </a>
                            <form class="app-search position-absolute">
                                <input type="text" class="form-control" placeholder="Search &amp; enter">
                                <a class="srh-btn">
                                    <i class="ti-close"></i>
                                </a>
                            </form>
                        </li>
                    </ul>
                    <ul class="navbar-nav float-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href=""
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    src="../../png/profile.png" alt="user" class="rounded-circle" width="31"></a>
                            <!-- <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <a class="dropdown-item" href="profile.php"><i class="ti-user m-r-5 m-l-5"></i>
                                    Developers Profile</a>
                                <a class="dropdown-item" href="error-404.html"><i class="ti-user m-r-5 m-l-5"></i>
                                    Future Researches</a>
                            </div> -->
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="index.php"
                                aria-expanded="false">
                                <i class="mdi mdi-file"></i>
                                <span class="hide-menu">Home</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="dashboard.php"
                                aria-expanded="false">
                                <i class="mdi mdi-av-timer"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="profile.php"
                                aria-expanded="false">
                                <i class="mdi mdi-account-network"></i>
                                <span class="hide-menu">Profile</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="signup.php"
                                aria-expanded="false">
                                <i class="mdi mdi-arrange-bring-forward"></i>
                                <span class="hide-menu">Sign-Up</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="prediction.php"
                                aria-expanded="false">
                                <i class="mdi mdi-border-none"></i>
                                <span class="hide-menu">prediction Table</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="main-content">
            <div class="container">
                <div class="page-breadcrumb">
                    <div class="row">
                        <div class="col-5 align-self-center">
                        </div>

                        <div class="col-7 align-self-center">
                            <div class="d-flex align-items-center justify-content-end">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="page-title" style="font-size: 50px; color: #137EFF;">Dashboard</h4>

            <div class="switches">
                <div class="switch" id="sw1" onclick="handleSwitch('soilCard')">Nutrient Levels</div>
                <div class="switch" id="sw2" onclick="handleSwitch('weatherCard')">Weather conditions</div>
                <div class="switch" id="sw3" onclick="handleSwitch('humidityCard')">Soil humidity vs time</div>
                <div class="switch" id="sw4" onclick="handleSwitch('tempCard')">Soil temp. vs time</div>
                <div class="switch" id="sw5" onclick="handleSwitch('overallCard')">Overall data</div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <!-- Soil humidity Card -->
                    <div style="width: 100%;" id="soilCard">
                        <div class="card h-100 d-flex flex-column">
                            <div class="card-body">
                                <h4 class="card-title">Soil Nutrient Levels Versus Time</h4>
                                <!-- Highcharts container -->
                                <div id="container" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Second card: Current Weather card -->
                    <div style="width: 100%;">
                        <div class="card hidden" id="weatherCard">
                            <div class="card-body">
                                <h4 class="card-title">Current Device Location Weather</h4>
                                <div class="d-flex align-items-center flex-row m-t-30">
                                    <div class="display-5 text-info">
                                        <i class="wi wi-day-showers"></i>
                                        <span id="current-temp">Loading...<sup>°</sup></span>
                                    </div>
                                    <div class="m-l-10">
                                        <h3 class="m-b-0" id="current-day">Loading...</h3>
                                        <small id="current-location">Loading...</small>
                                    </div>
                                </div>
                                <table class="table no-border mini-table m-t-20">
                                    <tbody>
                                        <tr>
                                            <td class="text-muted">Wind</td>
                                            <td class="font-medium" id="current-wind">Loading...</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Humidity</td>
                                            <td class="font-medium" id="current-humidity">Loading...</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Pressure</td>
                                            <td class="font-medium">28.56 in</td>
                                            <!-- Static value, update if you have pressure data -->
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Cloud Cover</td>
                                            <td class="font-medium">78%</td>
                                            <!-- Static value, update if you have cloud cover data -->
                                        </tr>
                                    </tbody>
                                </table>
                                <ul class="row list-style-none text-center m-t-30" id="hourly-forecast">
                                    <li class="col-3">
                                        <h4 class="text-info"><i class="wi wi-day-sunny"></i></h4>
                                        <span class="d-block text-muted">09:30</span>
                                        <h3 class="m-t-5">Loading...<sup>°</sup></h3>
                                    </li>
                                    <li class="col-3">
                                        <h4 class="text-info"><i class="wi wi-day-cloudy"></i></h4>
                                        <span class="d-block text-muted">11:30</span>
                                        <h3 class="m-t-5">Loading...<sup>°</sup></h3>
                                    </li>
                                    <li class="col-3">
                                        <h4 class="text-info"><i class="wi wi-day-hail"></i></h4>
                                        <span class="d-block text-muted">13:30</span>
                                        <h3 class="m-t-5">Loading...<sup>°</sup></h3>
                                    </li>
                                    <li class="col-3">
                                        <h4 class="text-info"><i class="wi wi-day-sprinkle"></i></h4>
                                        <span class="d-block text-muted">15:30</span>
                                        <h3 class="m-t-5">Loading...<sup>°</sup></h3>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <script>
                        // Function to fetch weather data
                        function fetchWeatherData(latitude, longitude) {
                            // Fetch weather data from the Open-Meteo API
                            fetch(`https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&current_weather=true&hourly=temperature_2m,relative_humidity_2m,wind_speed_10m`)
                                .then(response => response.json())
                                .then(data => {
                                    // Display current weather data
                                    document.getElementById('current-temp').textContent = data.current_weather.temperature;
                                    document.getElementById('current-wind').textContent = `${data.current_weather.windspeed} m/s`;
                                    document.getElementById('current-humidity').textContent = `${data.hourly.relative_humidity_2m[0]}%`; // Displaying humidity for the first hour

                                    // Display current location and date
                                    const now = new Date();
                                    document.getElementById('current-day').textContent = now.toLocaleDateString(undefined, { weekday: 'long' });

                                    // Fetch the location name using reverse geocoding
                                    fetch(`https://api.opencagedata.com/geocode/v1/json?q=${latitude}+${longitude}&key=YOUR_OPENCAGE_API_KEY`)
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.results && data.results.length > 0) {
                                                document.getElementById('current-location').textContent = data.results[0].formatted_address;
                                            } else {
                                                // If location not found, display the coordinates
                                                document.getElementById('current-location').textContent = `Latitude: ${latitude}, Longitude: ${longitude}`;
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error fetching location:', error);
                                            // Display the coordinates if there is an error
                                            document.getElementById('current-location').textContent = `Latitude: ${latitude}, Longitude: ${longitude}`;
                                        });

                                    // Display hourly forecast (for the first available hours)
                                    const hourlyTemperatures = [data.hourly.temperature_2m[0], data.hourly.temperature_2m[1], data.hourly.temperature_2m[2], data.hourly.temperature_2m[3]];

                                    const forecastItems = document.querySelectorAll('#hourly-forecast li h3');
                                    forecastItems.forEach((item, index) => {
                                        item.textContent = `${hourlyTemperatures[index]}°`;
                                    });
                                })
                                .catch(error => console.error('Error fetching weather data:', error));
                        }

                        // Get the user's current location
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(
                                position => {
                                    const latitude = position.coords.latitude;
                                    const longitude = position.coords.longitude;
                                    // Call function to fetch weather data using current location
                                    fetchWeatherData(latitude, longitude);
                                },
                                error => {
                                    console.error('Error getting location:', error);
                                    alert('Unable to retrieve your location.');
                                }
                            );
                        } else {
                            alert('Geolocation is not supported by this browser.');
                        }
                    </script>
                </div>
            </div>

            <!-- Highcharts script -->
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    // Parse the PHP data passed to JavaScript for nitrogen, phosphorus, and potassium
                    const nitrogenData = <?php echo json_encode(array_reverse($nitrogen_data)); ?>;
                    const phosphorusData = <?php echo json_encode(array_reverse($phosphorus_data)); ?>;
                    const potassiumData = <?php echo json_encode(array_reverse($potassium_data)); ?>;

                    Highcharts.chart('container', {
                        chart: {
                            type: 'area'
                        },
                        title: {
                            text: ' ',
                            align: 'left'
                        },
                        yAxis: {
                            title: {
                                useHTML: true,
                                text: 'Nutrient Level (ppm)'
                            }
                        },
                        tooltip: {
                            shared: true,
                            headerFormat: '<span style="font-size:12px"><b>{point.key}</b></span><br>'
                        },
                        plotOptions: {
                            series: {
                                pointStart: 1, // Adjust this if you want specific time labels
                            },
                            area: {
                                stacking: 'normal',
                                lineColor: '#666666',
                                lineWidth: 1,
                                marker: {
                                    lineWidth: 1,
                                    lineColor: '#666666'
                                }
                            }
                        },
                        series: [{
                            name: 'Nitrogen',
                            data: nitrogenData, // Use the PHP variable for nitrogen values
                            color: '#2E8B57' // You can customize this color
                        }, {
                            name: 'Phosphorus',
                            data: phosphorusData, // Use the PHP variable for phosphorus values
                            color: '#FFA500' // Customize the color for phosphorus
                        }, {
                            name: 'Potassium',
                            data: potassiumData, // Use the PHP variable for potassium values
                            color: '#1E90FF' // Customize the color for potassium
                        }]
                    });
                });
            </script>

            <!-- Cards row -->
            <div class="row">
                <!-- 3rd card: Soil humidity Card -->
                <div style="width: 100%;">
                    <div class="hidden" id="humidityCard">
                        <div class="card h-100 d-flex flex-column">
                            <div class="card-body">
                                <h5 class="card-title m-b-0">Soil humidity versus Time</h5>

                                <!-- Line Chart for Soil humidity -->
                                <canvas id="lineChart" style="max-height: 400px;"></canvas>
                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        const humidityData = <?php echo $humidity_data_json; ?>;
                                        new Chart(document.querySelector('#lineChart'), {
                                            type: 'line',
                                            data: {
                                                labels: ['0sec', '10sec', '20sec', '30sec', '40sec', '50sec', '60sec'],
                                                datasets: [{
                                                    label: 'humidity',
                                                    data: humidityData,
                                                    fill: false,
                                                    borderColor: 'rgb(75, 192, 192)',
                                                    tension: 0.1
                                                }]
                                            },
                                            options: {
                                                scales: {
                                                    y: {
                                                        beginAtZero: true
                                                    }
                                                }
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Soil Temperature Card -->
                <div style="width: 100%;">
                    <div id="tempCard" class="hidden">
                        <div class="card h-100 d-flex flex-column">
                            <div class="card-body">
                                <h5 class="card-title m-b-0">Soil Temperature versus Time</h5>
                                <!-- Bar Chart for Soil Temperature -->
                                <canvas id="barChart" style="max-height: 400px;"></canvas>
                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        const temperatureData = <?php echo $temperature_data_json; ?>;
                                        new Chart(document.querySelector('#barChart'), {
                                            type: 'bar',
                                            data: {
                                                labels: ['0sec', '10sec', '20sec', '30sec', '40sec', '50sec', '60sec'],
                                                datasets: [{
                                                    label: 'Temperature',
                                                    data: temperatureData,
                                                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                                    borderColor: 'rgba(255, 99, 132, 1)',
                                                    borderWidth: 1
                                                }]
                                            },
                                            options: {
                                                scales: {
                                                    y: {
                                                        beginAtZero: true
                                                    }
                                                }
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card hidden" id="overallCard">
                        <div class="card-body">
                            <h4 class="card-title">Overall Data</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">ID</th>
                                        <th class="border-top-0">HUMIDITY</th>
                                        <th class="border-top-0">TEMPERATURE</th>
                                        <th class="border-top-0">NITROGEN</th>
                                        <th class="border-top-0">PHOSPHORUS</th>
                                        <th class="border-top-0">POTASSIUM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Database connection details
                                    $servername = "localhost";
                                    $username = "root"; // Update with your database username
                                    $password = "Jay@2003"; // Update with your database password
                                    $dbname = "soilmonitoring"; // Database name
                                    
                                    // Create a connection
                                    $conn = new mysqli($servername, $username, $password, $dbname);

                                    // Check connection
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }

                                    // SQL query to retrieve data from soil_data table in reverse order by ID
                                    $sql = "SELECT id, humidity, temperature, nitrogen, phosphorus, potassium FROM soil_data ORDER BY id DESC LIMIT 10";
                                    $result = $conn->query($sql);

                                    // Check if there are results
                                    if ($result->num_rows > 0) {
                                        // Output data of each row
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td class='txt-oflo'>" . $row['id'] . "</td>";
                                            echo "<td><span class='label label-success label-rounded'>" . $row['humidity'] . "</span></td>";
                                            echo "<td class='txt-oflo'>" . $row['temperature'] . "</td>";
                                            echo "<td><span class='font-medium'>" . $row['nitrogen'] . "</span></td>";
                                            echo "<td><span class='font-medium'>" . $row['phosphorus'] . "</span></td>";
                                            echo "<td><span class='font-medium'>" . $row['potassium'] . "</span></td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'>No data found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <footer class="footer text-center" style="color: white; font-size: 30px; margin-top: 20px;">
                Smart Farming System
            </footer> -->
        </div>
    </div>
    <script>
        const handleSwitch = (cardToShow) => {
            // Get all cards and switches
            const cards = {
                soilCard: document.getElementById('soilCard'),
                weatherCard: document.getElementById('weatherCard'),
                humidityCard: document.getElementById('humidityCard'),
                tempCard: document.getElementById('tempCard'),
                overallCard: document.getElementById('overallCard')
            };

            // Get all switch buttons
            const switches = {
                soilCard: document.getElementById('sw1'),
                weatherCard: document.getElementById('sw2'),
                humidityCard: document.getElementById('sw3'),
                tempCard: document.getElementById('sw4'),
                overallCard: document.getElementById('sw5')
            };

            // Hide all cards
            Object.values(cards).forEach(card => {
                card.classList.add('hidden');
            });

            // Remove active class from all switches
            Object.values(switches).forEach(switchBtn => {
                switchBtn.classList.remove('active');
            });

            // Show selected card and activate corresponding switch
            cards[cardToShow].classList.remove('hidden');
            switches[cardToShow].classList.add('active');
        };

        // Set initial active state
        document.addEventListener('DOMContentLoaded', () => {
            handleSwitch('soilCard'); // Set initial active card
        });    
    </script>
    <script src="../../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../../assets/extra-libs/sparkline/sparkline.js"></script>
    <script src="../../dist/js/waves.js"></script>
    <script src="../../dist/js/sidebarmenu.js"></script>
    <script src="../../dist/js/custom.min.js"></script>
    <script src="../../assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="../../assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="../../dist/js/pages/dashboards/dashboard1.js"></script>
</body>

</html>
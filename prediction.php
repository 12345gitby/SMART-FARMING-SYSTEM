<?php
// Read data from the Python-generated JSON file
$json_data = file_get_contents('C:\laragon\www\jays_major_project\my_flashk_api\prediction_model\model_output.json');
$data = json_decode($json_data, true);

// Assign data to variables
$model_accuracy = $data['model_accuracy'];
$recommended_crop = $data['recommended_crop'];
$recommended_fertilizer = $data['recommended_fertilizer'];
$water_required_per_day = $data['water_required_per_day'];
$sensor_data = $data['sensor_data'];
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
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <a class="dropdown-item" href="profile.php"><i class="ti-user m-r-5 m-l-5"></i>
                                    Developers Profile</a>
                                <a class="dropdown-item" href="error-404.html"><i class="ti-user m-r-5 m-l-5"></i>
                                    Future Researches</a>
                            </div>
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
                            <!-- <h4 class="page-title">Dashboard</h4> -->
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
            <div class="switches">
                <div class="switch" id="sw1" onclick="handleSwitch('predictionDetailsCard')">Crop Prediction Details</div>
                <div class="switch" id="sw2" onclick="handleSwitch('predictedFeaturesCard')">Predicted Features of Soil</div>
                <div class="switch" id="sw3" onclick="handleSwitch('recommendedFertilizersCard')">Recommended Fertilizers</div>
                <div class="switch" id="sw4" onclick="handleSwitch('waterRequirementCard')">Water Requirement of Predicted Crop</div>
            </div>
            <br>
            </br>
            <!-- Cards row -->
            <div class="row">
                <div style="width: 100vw;">
                    <div class="card" id="predictionDetailsCard">
                        <div class="card-body">
                            <h5 class="card-title">Crop Prediction Details</h5>
                            <p class="card-text"><b>Accuracy of the Model:</b>
                                <?php echo $model_accuracy . "%"; ?>
                            </p>
                            <p class="card-text"><b>Recommended Crop:</b>
                                <?php echo $recommended_crop; ?>
                            </p>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Feature</th>
                                        <th scope="col">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Display sensor data in the table
                                    foreach ($sensor_data as $feature => $value) {
                                        echo "<tr>";
                                        echo "<td>" . $feature . "</td>";
                                        echo "<td>" . $value . "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div style="width: 100vw;">
                    <div id="predictedFeaturesCard" >
                        <div class="card h-100 d-flex flex-column">
                            <div class="card-body">
                                <h5 class="card-title mb-0">Predicted Features of Soil</h5>
                                <div>
                                    <canvas id="pieChart" style="max-height: 400px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Include Chart.js -->
                <script>
    // Get sensor data from PHP (passed as JSON arrays)
    const features = <?php echo json_encode(array_keys($sensor_data)); ?>;
    const values = <?php echo json_encode(array_values($sensor_data)); ?>;

    // Pie chart configuration
    const data = {
        labels: features,
        datasets: [{
            label: 'Sensor Data',
            data: values,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(100, 149, 237, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(100, 149, 237, 1)'
            ],
            borderWidth: 1
        }]
    };

    const config = {
        type: 'pie',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top', // Set legend position
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return context.label + ': ' + context.raw; // Show the raw value
                        }
                    }
                }
            }
        }
    };

    // Render the pie chart
    var ctx = document.getElementById('pieChart').getContext('2d');
    new Chart(ctx, config);
</script>

                <div style="width: 100vw;">
                    <div class="card" id="recommendedFertilizersCard">
                        <div class="card-body">
                            <h5 class="card-title">Recommended Fertilizers</h5>
                            <p class="card-text"><b>Accuracy of the Model:</b>
                                <?php echo $model_accuracy . "%"; ?>
                            </p>
                            <p class="card-text"><b>Recommended Fertilizer :</b>
                                <?php echo $recommended_fertilizer; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div style="width: 100vw;">
                    <div class="card" id="waterRequirementCard">
                        <div class="card-body">
                            <h5 class="card-title">Water Requirement of Predicted Crop</h5>
                            <p class="card-text"><b>Accuracy of the Model:</b>
                                <?php echo $model_accuracy . "%"; ?>
                            </p>
                            <p class="card-text"><b>Water level in mm/Day: :</b>
                                <?php echo $water_required_per_day; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second Card - Display Sensor Data in a Pie Chart -->

            <!-- <footer class="footer text-center">
                        Smart Farming System
                    </footer> -->
        </div>
    </div>
    <script>
        const handleSwitch = (cardToShow) => {
            // Get all cards and switches
            const cards = {
                predictionDetailsCard: document.getElementById('predictionDetailsCard'),
                predictedFeaturesCard: document.getElementById('predictedFeaturesCard'),
                recommendedFertilizersCard: document.getElementById('recommendedFertilizersCard'),
                waterRequirementCard: document.getElementById('waterRequirementCard'),
            };

            // Get all switch buttons
            const switches = {
                predictionDetailsCard: document.getElementById('sw1'),
                predictedFeaturesCard: document.getElementById('sw2'),
                recommendedFertilizersCard: document.getElementById('sw3'),
                waterRequirementCard: document.getElementById('sw4'),
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
            handleSwitch('predictionDetailsCard'); // Set initial active card
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
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="png/soilmonitor.png">
    <title>Soil Monitor</title>
    <link href="../../assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="../../dist/css/style.min.css" rel="stylesheet">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-image: url('png/bg1.png');
            background-size: cover;
            /* This will scale the image to cover the entire area */
            background-repeat: no-repeat;
            /* Prevents the image from repeating */
            background-position: center;
            /* Centers the image */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            /* background-color: black; */
            background-image: url('../../png/homeBg.jpg');
            object-fit: contain;
        }

        .transparent-container h4.page-title {
            color: #fff;
            /* White text */
        }

        .card {
            margin-top: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .card-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: black;
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

        .container {
            display: flex;
            justify-content: space-evenly;
            gap: 20px;
        }

        .transparent-container {
            background-color: rgba(255, 255, 255, 0.8);
            /* Semi-transparent background */
        }

        .desc {
            color: black;
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
                            <!-- <a class="nav-link waves-effect waves-dark" href="javascript:void(0)">
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-magnify font-20 mr-1"></i>
                                    <div class="ml-1 d-none d-sm-block">
                                        <span>Search</span>
                                    </div>
                                </div>
                            </a> -->
                            <!-- <form class="app-search position-absolute">
                                <input type="text" class="form-control" placeholder="Search &amp; enter">
                                <a class="srh-btn">
                                    <i class="ti-close"></i>
                                </a>
                            </form> -->
                        </li>
                    </ul>
                    <h1
                        style="color: white; font-weight: bold; font-size: 40px; background: linear-gradient(to top, red, yellow); -webkit-background-clip: text; -webkit-text-fill-color: transparent; width: 70vw; text-align: center;">
                        Soil Monitoring System</h1>
                    <ul></ul>
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
                        <!-- <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="dashboard.php" aria-expanded="false">
                                <i class="mdi mdi-av-timer"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li> -->
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="profile.php"
                                aria-expanded="false">
                                <i class="mdi mdi-account-network"></i>
                                <span class="hide-menu">Profile</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="login.php"
                                aria-expanded="false">
                                <i class="mdi mdi-arrange-bring-forward"></i>
                                <span class="hide-menu">Login-In</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="signup.php"
                                aria-expanded="false">
                                <i class="mdi mdi-arrange-bring-forward"></i>
                                <span class="hide-menu">Sign-Up</span>
                            </a>
                        </li>
                        <!-- <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="error-404.html"
                                aria-expanded="false">
                                <i class="mdi mdi-alert-outline"></i>
                                <span class="hide-menu">404</span>
                            </a>
                        </li> -->
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
                        <!-- <div class="col-7 align-self-center">
                            <div class="d-flex align-items-center justify-content-end">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                    </ol>
                                </nav>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="card transparent-container">
                    <h4 class="card-title">Crop suggestion</h4>
                    <p class="desc">
                        Based on current soil pH levels, moisture content, and NPK readings, the best crops to plant in
                        your field this season are wheat, maize, and soybean. These crops will optimize soil use and
                        yield in the current climatic conditions.
                    </p>
                </div>
                <div class="card transparent-container">
                    <h4 class="card-title">Fertilizer suggestion</h4>
                    <p class="desc">
                        To improve crop yield, we recommend using nitrogen-based fertilizers like urea, as the soil
                        nitrogen levels are slightly deficient. For balanced NPK levels, consider a mix of potassium
                        sulfate and phosphorus-based fertilizers.
                    </p>
                </div>
                <div class="card transparent-container">
                    <h4 class="card-title">Water requirement</h4>
                    <p class="desc">
                        The crops require approximately 20 liters of water per square meter every three days. Current
                        soil moisture levels suggest moderate irrigation to avoid waterlogging and optimize plant
                        growth.
                    </p>
                </div>
                <div class="card transparent-container">
                    <h4 class="card-title">Soil health</h4>
                    <p class="desc">
                        Soil health is stable, but there is a need to improve organic matter content. Consider adding
                        compost or organic manure to improve fertility and enhance microbial activity in the soil.
                    </p>
                </div>
            </div>

            <br>
            </br>
            <!-- <div class="card transparent-container">
                <h4 class="card-title">Features</h4>
                <ul>
                    <li>Real-time monitoring of soil parameters</li>
                    <li>Data visualization through dynamic graphs</li>
                    <li>Easy-to-use web interface</li>
                    <li>Integration with IoT devices for remote access</li>
                    <li>Alerts for critical soil conditions</li>
                </ul>
            </div> -->


            <!-- <footer class="footer text-center">
                Smart Farming System
            </footer> -->
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
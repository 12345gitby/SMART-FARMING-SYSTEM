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
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="login.php"
                                aria-expanded="false">
                                <i class="mdi mdi-arrange-bring-forward"></i>
                                <span class="hide-menu">Login-In</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="signup.php"
                                aria-expanded="false">
                                <i class="mdi mdi-arrange-bring-forward"></i>
                                <span class="hide-menu">Sign-Up</span>
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
                            <h4 class="page-title">Dashboard</h4>
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
            <br>
            </br>

            <div class="container-fluid">
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <center class="m-t-30"> <img src="../../assets/images/users/69.jpg"
                                        class="rounded-circle" width="150" />
                                    <h4 class="card-title m-t-10">Jay Subhash Bele</h4>
                                    <h6 class="card-subtitle">Computer Science</h6>
                                    <div class="row text-center justify-content-md-center">
                                        <div class="col-8">
                                            <p class="font-medium">
                                                <i class="icon-people"></i> A tech enthusiast with a focus on AI,
                                                database research, leadership, and debate, actively involved in
                                                impactful projects and initiatives.
                                            </p>
                                        </div>
                                    </div>

                                </center>
                            </div>
                            <div>
                                <hr>
                            </div>
                            <div class="card-body"> <small class="text-muted">Email address </small>
                                <h6><a href="mailto:belejay38@gmail.com">belejay38@gmail.com</a></h6>
                                <small class="text-muted p-t-30 db">Phone</small>
                                <h6><a href="tel:+916005947762">+91 6005947762</a></h6>
                                <small class="text-muted p-t-30 db">GitHub</small>
                                <h6><a href="https://github.com/12345gitby"
                                        target="_blank">https://github.com/12345gitby</a></h6>
                                <small class="text-muted p-t-30 db">LinkedIn</small>
                                <h6><a href="https://www.linkedin.com/in/mohd-rafiq-5263b0229/"
                                        target="_blank">https://www.linkedin.com/in/mohd-rafiq-5263b0229/</a></h6>

                                <div class="map-box">
                                </div> <small class="text-muted p-t-30 db"> </small>
                                <br />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <center class="m-t-30"> <img src="../../assets/images/users/67.jpg"
                                        class="rounded-circle" width="150" />
                                    <h4 class="card-title m-t-10">Moh rafiq</h4>
                                    <h6 class="card-subtitle">Computer Engineering</h6>
                                    <div class="row text-center justify-content-md-center">
                                        <!-- <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-people"></i> <font class="font-medium">A tech enthusiast with a passion for coding in Python and innovative problem-solving. Actively involved in organizing events and always exploring new technology trends to make an impact.</font></a></div> -->
                                        <!-- <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-picture"></i> <font class="font-medium"> </font></a></div> -->
                                        <div class="col-8">
                                            <p class="font-medium">
                                                <i class="icon-people"></i> A tech enthusiast with a passion for coding
                                                in Python and innovative problem-solving. Actively involved in
                                                organizing events and always exploring new technology trends to make an
                                                impact.
                                            </p>
                                        </div>
                                    </div>
                                    <!-- </div> -->
                                </center>
                            </div>
                            <div>
                                <hr>
                            </div>
                            <div class="card-body"> <small class="text-muted">Email address </small>
                                <h6><a href="mailto:mohdrafiq@gmail.com">mohdrafiq@gmail.com</a></h6>
                                <small class="text-muted p-t-30 db">Phone</small>
                                <h6><a href="tel:+91654784547">+91 654 784 547</a></h6>
                                <small class="text-muted p-t-30 db">GitHub</small>
                                <h6><a href="https://github.com/MohdRafiq1"
                                        target="_blank">https://github.com/MohdRafiq1</a></h6>
                                <small class="text-muted p-t-30 db">LinkedIn</small>
                                <h6><a href="https://www.linkedin.com/in/mohd-rafiq-5263b0229/"
                                        target="_blank">https://www.linkedin.com/in/mohd-rafiq-5263b0229/</a></h6>

                                <div class="map-box">
                                    <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d470029.1604841957!2d72.29955005258641!3d23.019996818380896!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e848aba5bd449%3A0x4fcedd11614f6516!2sAhmedabad%2C+Gujarat!5e0!3m2!1sen!2sin!4v1493204785508" width="100%" height="150" frameborder="0" style="border:0" allowfullscreen></iframe> -->
                                </div> <small class="text-muted p-t-30 db"> </small>
                                <br />
                                <!-- <button class="btn btn-circle btn-secondary"><i class="mdi mdi-facebook"></i></button> -->
                                <!-- <button class="btn btn-circle btn-secondary"><i class="mdi mdi-twitter"></i></button> -->
                                <!-- <button class="btn btn-circle btn-secondary"><i class="mdi mdi-youtube-play"></i></button> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <!-- <center class="m-t-30"> <img src="D:\data analytics\jay\prasad.jpg" class="rounded-circle" width="150" /> -->
                                <center class="m-t-30"> <img src="../../assets/images/users/68.jpg"
                                        class="rounded-circle" width="150" />
                                    <h4 class="card-title m-t-10">Prasad S.Joshi</h4>
                                    <h6 class="card-subtitle">Computer Engineering</h6>
                                    <div class="row text-center justify-content-md-center">
                                        <div class="col-8">
                                            <p class="font-medium">
                                                <i class="icon-people"></i> Enthusiastic Frontend Developer with strong
                                                skills in web development. Experienced in building efficient, responsive
                                                websites using modern technologies.
                                            </p>
                                        </div>
                                        <!-- <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-people"></i> <font class="font-medium">Enthusiastic Frontend Developer with strong skills in web development. Experienced in building efficient, responsive websites using modern technologies. Passionate about solving problems and continuously improving user experiences through creative, detail-oriented solutions.</font></a></div>
                                        <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-picture"></i> <font class="font-medium"> </font></a></div>
                                    </div> -->
                                </center>
                            </div>
                            <div>
                                <hr>
                            </div>
                            <div class="card-body"> <small class="text-muted">Email address </small>
                                <h6><a href="mailto:prasadjoshi260302@gmail.com">prasadjoshi260302@gmail.com</a></h6>
                                <small class="text-muted p-t-30 db">Phone</small>
                                <h6><a href="tel:+918767481258">+91 8767481258</a></h6>
                                <small class="text-muted p-t-30 db">GitHub</small>
                                <h6><a href="https://github.com/prasad-joshi7?tab=repositories"
                                        target="_blank">https://github.com/prasad-joshi7?tab=repositories</a></h6>
                                <small class="text-muted p-t-30 db">LinkedIn</small>
                                <h6><a href="https://www.linkedin.com/in/prasad-joshi-339a49226?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app"
                                        target="_blank">https://www.linkedin.com/in/prasad-joshi-339a49226</a></h6>

                                <div class="map-box">
                                    <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d470029.1604841957!2d72.29955005258641!3d23.019996818380896!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e848aba5bd449%3A0x4fcedd11614f6516!2sAhmedabad%2C+Gujarat!5e0!3m2!1sen!2sin!4v1493204785508" width="100%" height="150" frameborder="0" style="border:0" allowfullscreen></iframe> -->
                                </div> <small class="text-muted p-t-30 db"> </small>
                                <br />
                                <!-- <button class="btn btn-circle btn-secondary"><i class="mdi mdi-facebook"></i></button> -->
                                <!-- <button class="btn btn-circle btn-secondary"><i class="mdi mdi-twitter"></i></button> -->
                                <!-- <button class="btn btn-circle btn-secondary"><i class="mdi mdi-youtube-play"></i></button> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <center class="m-t-30">
                                    <img src="../../assets/images/users/vishakha.jpg" class="rounded-circle" width="150"
                                        height="150" />
                                    <h4 class="card-title m-t-10">Vishakha D. Kurzekar</h4>
                                    <h6 class="card-subtitle">Computer Engineering</h6>
                                    <div class="row text-center justify-content-md-center">
                                        <div class="col-8">
                                            <p class="font-medium">
                                                <i class="icon-people"></i>
                                                I’m a full-stack developer skilled in front-end (HTML5, CSS3, React,
                                                Angular) and back-end (Node.js, Express, Django) with experience in
                                                MongoDB and MySQL
                                            </p>
                                        </div>
                                    </div>
                                </center>
                            </div>
                            <div>
                                <hr>
                            </div>
                            <div class="card-body"> <small class="text-muted"></small>
                                <h6><a href="mailto:vishakhakurzekar28@gmail.com">vishakhakurzekar28@gmail.com</a></h6>
                                <small class="text-muted p-t-30 db">Phone</small>
                                <h6><a href="tel:+919823834661">+91 9823834661</a></h6>
                                <small class="text-muted p-t-30 db">LinkedIn</small>
                                <h6><a href="https://linkedin.com/in/vishakha-kurzekar"
                                        target="_blank">https://linkedin.com/in/vishakha-kurzekar</a></h6>
                                <small class="text-muted p-t-30 db">GitHub</small>
                                <h6><a href="https://github.com/Vishakhakurzekar"
                                        target="_blank">https://github.com/Vishakhakurzekar</a></h6>

                                <div class="map-box">
                                    <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d470029.1604841957!2d72.29955005258641!3d23.019996818380896!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e848aba5bd449%3A0x4fcedd11614f6516!2sAhmedabad%2C+Gujarat!5e0!3m2!1sen!2sin!4v1493204785508" width="100%" height="150" frameborder="0" style="border:0" allowfullscreen></iframe> -->
                                </div> <small class="text-muted p-t-30 db"> </small>
                                <br />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer text-center" style="color: white;">
                Smart Farming System
            </footer>
        </div>
    </div>
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
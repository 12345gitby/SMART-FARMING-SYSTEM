<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Update with your database username
$password = "Jay@2003"; // Update with your database password
$dbname = "soilmonitoring"; // Database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$signup_success = false; // Variable to check if signup was successful

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if password and confirm password match
    if ($password === $confirm_password) {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (email, full_name, username, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $email, $full_name, $username, $hashed_password);

        // Execute the statement
        if ($stmt->execute()) {
            $signup_success = true; // Set the flag for successful signup
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Passwords do not match.";
    }
}

// Close the connection
$conn->close();
?>

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

    <!-- Custom CSS -->
    <link href="../../assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="../../dist/css/style.min.css" rel="stylesheet">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    

  <style>
    body {
      background-image: url('../../png/makka.jpg');
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 20px;
    }  

    .transparent-container h4.page-title {
    color: #fff; /* White text */
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
      height: 400px; /* Set height for the chart */
    }


    .left-sidebar {
        /* width: 250px; */
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        background-color: #343a40; /* Custom sidebar color */
        padding-top: 60px;
        z-index: 100;
    }

    .main-content {
        margin-left: 250px; /* Same width as the sidebar */
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
        background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
    }
  </style>

  
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-navbarbg="skin6" data-theme="light" data-layout="vertical" data-sidebartype="full" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header" data-logobg="skin5">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="ti-menu ti-close"></i>
                    </a>
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent"
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
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../../png/profile.png" alt="user" class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                            <a class="dropdown-item" href="profile.php"><i class="ti-user m-r-5 m-l-5"></i> Developers Profile</a>
                            <a class="dropdown-item" href="error-404.html"><i class="ti-user m-r-5 m-l-5"></i> Future Researches</a>
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
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="index.php" aria-expanded="false">
                                <i class="mdi mdi-file"></i>
                                <span class="hide-menu">Home</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="profile.php" aria-expanded="false">
                                <i class="mdi mdi-account-network"></i>
                                <span class="hide-menu">Profile</span>
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
                    <div class="col-12">
                        <div class="card card-body" style="background-color: rgba(255, 255, 255, 0.5);">
                            <h4 class="card-title">Sign-Up</h4>
                            <h5 class="card-subtitle"> Enter your details </h5>
                            <!-- Success Message -->
                    <?php if ($signup_success): ?>
                        <div class="alert alert-success" role="alert">
                            Signup successful! You can now <a href="login.php" class="alert-link">Login</a>.
                        </div>
                    <?php endif; ?>
                            <form action="signup.php" class="form-horizontal m-t-30" style="max-width: 400px; margin: auto;" method="POST" action="process_signup.php">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Email</span>
                                    <input type="email" name="email" class="form-control" placeholder="Enter your Email" aria-label="Enter your Email" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon2">Full Name</span>
                                    <input type="text" name="full_name" class="form-control" placeholder="Enter User's Full Name" aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                                </div>
                                <div class="mb-3">
                                    <span class="input-group-text" id="basic-addon3">Password</span>
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control" aria-describedby="basic-addon3" placeholder="Enter your password" required>
                                    </div>
                                    <span class="input-group-text" id="basic-addon4">Confirm Password</span>
                                    <div class="input-group mb-3">
                                        <input type="password" name="confirm_password" class="form-control" aria-label="Confirm Password" placeholder="Confirm your password" required>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon5">User Name</span>
                                    <input type="text" name="username" class="form-control" placeholder="Username" aria-label="Username" required>
                                </div>
                                <div class="text-center mt-3">
                                    <button type="submit" value="Signup" class="btn btn-primary">Submit</button>
                                </div>
                                <div class="text-center mt-3">
                                    <p>Already have an account? <a href="Login.php">Login</a></p>
                                </div>
                            </form>

                        </div>
                    </div>
                    </div>
                </div>
            </div>
        <footer class="footer text-center">
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
<?php $currentPage = basename($_SERVER['PHP_SELF']) ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap + Icons -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- custom css -->
    <link href="assests/css/style.css" rel="stylesheet">
    <link href="assests/css/media-query.css" rel="stylesheet">


</head>

<body>

    <!-- Ambient Glow Blobs Background -->
    <div class="glowing-orb orb-left"></div>
    <div class="glowing-orb orb-right"></div>

    <!-- MAIN DASHBOARD CONTAINER -->
    <div class="wrapper">

        <!-- SIDEBAR -->
        <aside class="sidebar glass-card">
            <div>

                <div class="brand-logo">
                    <div class="brand-icon">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div class="brand-name">
                        <h1>SMS</h1>
                    </div>
                </div>

                <div class="nav-item <?= ($currentPage == 'index.php' ? 'active' : '') ?>">
                    <div><i class="fa fa-house"></i></div>
                    <div><a href="">Dashboard</a></div>
                </div>

                <div class="nav-item <?= ($currentPage == 'students.php' ? 'active' : '') ?>">
                    <div><i class="fa fa-user"></i></div>
                    <div><a href="students.php">Students</a></div>
                </div>

                <div class="nav-item <?= ($currentPage == 'classes.php' ? 'active' : '') ?>">
                    <div><i class="fa fa-school"></i></div>
                    <div><a href="classes.php">Classes</a></div>
                </div>
                <div class="nav-item <?= ($currentPage == 'attendance.php' ? 'active' : '') ?>">
                    <div><i class="fa fa-calendar"></i></div>
                    <div><a href="attendance.php">Attendence</a></div>
                </div>
                <div class="nav-item">
                    <div><i class="fa fa-wallet"></i></div>
                    <div><a href="#">Fees</a></div>
                </div>
                <div class="nav-item">
                    <div><i class="fa fa-chart-line"></i></div>
                    <div><a href="#">Results</a></div>
                </div>
                <div class="nav-item">
                    <div><i class="fa fa-bell"></i></div>
                    <div><a href="#" class="nav-link">Notices</a></div>
                </div>
                <div class="nav-item">
                    <div><i class="fa fa-gear"></i></div>
                    <div><a href="#" class="nav-link">Settings</a></div>
                </div>
            </div>
        </aside>
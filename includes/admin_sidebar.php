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
    <link href="/student_management_system/assets/css/style.css" rel="stylesheet">
    <link href="/student_management_system/assets/css/media-query.css" rel="stylesheet">


</head>

<body>

    <!-- Ambient Glow Blobs Background -->
    <div class="glowing-orb orb-left"></div>
    <div class="glowing-orb orb-right"></div>

    <!-- MAIN DASHBOARD CONTAINER -->
    <div class="wrapper">

        <!-- For SMALL SCREENS -->
        <div class="mobile-header">

            <div style="display: flex; gap: 5px;">

                <button id="menuToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="mobile-logo">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <span>SMS</span>
                </div>
            </div>

            <?php

            $userName = $_SESSION['user_name'];
            $userEmail = $_SESSION['user_email'];
            $userRole = $_SESSION['role'];

            $profileImage = !empty($_SESSION['user_image'])
                ? "/student_management_system/" . $_SESSION['user_image']
                : "/student_management_system/uploads/profile-img.jpg";

            ?>

            <div style="display: flex; gap:5px;">

                <button class="btn-primary" style="border: none; padding: 8px 16px; border-radius: 10px; font-size: 12.5px; font-weight: 700;">
                    <?= $userRole ?>
                </button>

                <!-- USER PROFILE DROPDOWN CONTAINER -->
                <div class="user-profile-container mobile">
                    <button class="profile-trigger-btn" id="profileTrigger" aria-label="Open user menu">
                        <img src="<?= $profileImage ?>" alt="User Profile" class="user-avatar">
                    </button>

                    <div class="profile-dropdown-menu" id="profileDropdown">
                        <div class="dropdown-header">
                            <img src="<?= $profileImage ?>" alt="User Profile" class="dropdown-avatar">
                            <div class="user-info">
                                <h4><?= $userName ?></h4>
                                <p><?= $userEmail ?></p>
                            </div>
                        </div>
                        <hr class="dropdown-divider">
                        <ul class="dropdown-links">
                            <li><a href="#" class="menu-action" data-action="Profile"><i class="fa-solid fa-user"></i> My Profile</a></li>
                            <li><a href="#" class="menu-action" data-action="Settings"><i class="fa-solid fa-gear"></i> Account Settings</a></li>
                            <li><a href="#" class="menu-action logout-link" data-action="Logout"><i class="fa-solid fa-right-from-bracket"></i> Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>



        </div>

        <!-- SIDEBAR -->
        <aside class="sidebar glass-card" id="sidebar">
            <div>

                <div class="brand-logo">
                    <div class="brand-icon">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div class="brand-name">
                        <h1>SMS</h1>
                    </div>
                </div>

                <div class="nav-item <?= ($currentPage == 'index.php' ? 'active' : '') ?>" title="Dashboard">
                    <div><i class="fa fa-house"></i></div>
                    <div class="nav-text"><a href="">Dashboard</a></div>
                </div>

                <a href="/student_management_system/admin/students.php">
                    <div class="nav-item <?= ($currentPage == 'students.php' ? 'active' : '') ?>" title="Students">
                        <div><i class="fa fa-user"></i></div>
                        <div class="nav-text">Students</div>
                    </div>
                </a>

                <a href="/student_management_system/admin/teachers.php">
                    <div class="nav-item <?= ($currentPage == 'teachers.php' ? 'active' : '') ?>" title="Students">
                        <div><i class="fa fa-user"></i></div>
                        <div class="nav-text">Teachers</div>
                    </div>
                </a>

                <a href="classes.php">
                    <div class="nav-item <?= ($currentPage == 'classes.php' ? 'active' : '') ?>" title="Classes">
                        <div><i class="fa fa-school"></i></div>
                        <div class="nav-text">Classes</div>
                    </div>
                </a>

                <div class="nav-item <?= ($currentPage == 'attendance.php' ? 'active' : '') ?>" title="Attendance">
                    <div><i class="fa fa-calendar"></i></div>
                    <div class="nav-text"><a href="attendance.php">Attendence</a></div>
                </div>
                <div class="nav-item" title="Fees">
                    <div><i class="fa fa-wallet"></i></div>
                    <div class="nav-text"><a href="#">Fees</a></div>
                </div>
                <div class="nav-item" title="Results">
                    <div><i class="fa fa-chart-line"></i></div>
                    <div class="nav-text"><a href="#">Results</a></div>
                </div>
                <div class="nav-item">
                    <div><i class="fa fa-bell"></i></div>
                    <div class="nav-text"><a href="#" class="nav-link">Notices</a></div>
                </div>
                <div class="nav-item">
                    <div><i class="fa fa-gear"></i></div>
                    <div class="nav-text"><a href="#" class="nav-link">Settings</a></div>
                </div>
            </div>
        </aside>

        <div class="sidebar-overlay" id="sidebarOverlay"></div>
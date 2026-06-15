<?php

// ROLE BASED AUTHENTICATION
include $_SERVER['DOCUMENT_ROOT'] . "/student_management_system/includes/teacher_auth.php";

// include sidebar
include $_SERVER['DOCUMENT_ROOT'] . "/student_management_system/includes/teacher_sidebar.php";

// include connection
include $_SERVER['DOCUMENT_ROOT'] . "/student_management_system/config/connection.php";

?>

<main class="main-content">

    <!-- TOPBAR -->
    <header class="topbar glass-card">

        <div class="topbar-title">

            <button id="sidebarCollapseBtn" class="sidebar-toggle-btn">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="header-text">
                <h2>Attendance Management</h2>
                <p>Manage daily student attendance records.</p>
            </div>

        </div>

        <div class="topbar-btns">

            <button type="button" onclick="markAllPresent()" class="btn" id="markAllPresent" style="display:none; background-color: #2a9d8f; color: white; box-shadow: 0px 2px 5px rgba(42, 157, 143, 0.4);">
                <i class="fa-solid fa-check-double"></i>
                <span>Mark All Present</span>
            </button>

            <button
                type="submit"
                class="btn btn-primary" id="saveAttendence" style="display: none;">

                <i class="fa-solid fa-floppy-disk"></i>
                Save Attendance

            </button>

            <?php

            $userName = $_SESSION['user_name'];
            $userEmail = $_SESSION['user_email'];
            $userRole = $_SESSION['role'];

            $profileImage = !empty($_SESSION['user_image'])
                ? "/student_management_system/" . $_SESSION['user_image']
                : "/student_management_system/uploads/profile-img.jpg";


            ?>

            <div class="btn-primary" style="padding: 8px 16px; border-radius: 10px; font-size: 12.5px; font-weight: 700;">
                <?= $userRole ?>
            </div>

            <!-- USER PROFILE DROPDOWN CONTAINER -->
            <div class="user-profile-container">
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

    </header>

    <!-- FILTER BAR -->
    <section class="btn-group glass-card" style="margin-bottom: 12px;">

        <!-- <div class="search-box">

            <input type="text" id="attendanceSearch" placeholder="Search Student...">

            <i class="fa-solid fa-magnifying-glass"></i>

        </div> -->

        <div class="filter-group">

            <!-- DATE -->
            <input type="date" id="attendanceDate" class="select-custom" value="<?php echo date('Y-m-d'); ?>">

            <div id="attendance-tabs" class="tab-container">
                <!-- DYNAMICALLY CREATED BY JS -->
            </div>

            <button type="button" class="btn btn-primary" onclick="loadAttendence()"><i class="fa-solid fa-rotate"></i> Load Students</button>

        </div>

    </section>

    <!-- ATTENDANCE FORM -->

    <section class="student-record glass-card" style="display: none;">

        <div class="table-scroll">

            <form action="save_attendance.php" method="POST" id="attendence-form">

                <input
                    type="hidden"
                    name="attendance_date"
                    id="attendanceDateHidden"
                    value="<?php echo date('Y-m-d'); ?>">

                <input
                    type="hidden"
                    name="section_id"
                    id="section_id">

                <table id="attendanceTable">

                    <thead>

                        <tr>

                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Attendance</th>
                            <th>Remarks</th>

                        </tr>

                    </thead>

                    <tbody class="table-body">
                        <!-- DYNAMICALLY ADDED BY ATTENDENCE.JS -->
                    </tbody>

                </table>

            </form>

        </div>

    </section>

    <!-- Unloaded Information Card -->
    <div class="glass-card" id="unloaded-placeholder">
        <i class="fa-solid fa-calendar-days"></i>
        <h3>No Class Selected</h3>
        <p>Select a Class, Section, and Date from the filters above and load your interactive roll-call table.</p>
    </div>

    <!-- NO RECORD FOUND -->
    <div class="glass-card empty-state">
        <i class="fa-solid fa-folder-open"></i>
        <h3>No Records Found</h3>
        <p>
            No attendance records are available for the selected
            Class, Section, and Date.
        </p>
    </div>

    <?php
    // confirmation dialogue box
    include $_SERVER['DOCUMENT_ROOT'] . "/student_management_system/includes/confirmation-dialogue-box.php";
    ?>

    <!-- TOAST -->
    <div class="toast-container" id="toastContainer"></div>

</main>

</div>

<!-- // include js -->
<script src="/student_management_system/assets/js/script.js"></script>
<script src="/student_management_system/assets/js/teacher-attendance.js"></script>


<?php if (isset($_SESSION['toast'])) { ?>

    <script>
        document.addEventListener(
            "DOMContentLoaded",
            function() {

                showToast(
                    "<?= $_SESSION['toast']['message'] ?>",
                    "<?= $_SESSION['toast']['type'] ?>",
                    "<?= $_SESSION['toast']['title'] ?>"
                );

            }
        );
    </script>

<?php
    unset($_SESSION['toast']);
}
?>

</body>

</html>
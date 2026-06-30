<?php

// ROLE BASED AUTHENTICATION
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/admin/admin_auth.php";

// include sidebar
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/admin/admin_sidebar.php";

// include connection
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

?>

<main class="main-content">

    <!-- TOPBAR -->
    <header class="topbar glass-card attendance">

        <div class="topbar-title">

            <button id="sidebarCollapseBtn" class="sidebar-toggle-btn">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="header-text">
                <h2>Attendance Management</h2>
                <p>Manage daily student attendance records.</p>
            </div>

        </div>

        <div class="topbar-btns" style="display: flex; gap: 10px;">

            <button type="button" onclick="markAllPresent()" class="btn" id="markAllPresent" style="display:none; background-color: #2a9d8f; color: white; box-shadow: 0px 2px 5px rgba(42, 157, 143, 0.4); width: 90%;">
                <i class="fa-solid fa-check-double"></i>
                <span>Mark All Present</span>
            </button>

            <button
                type="submit"
                class="btn btn-primary" id="saveAttendence" style="display: none; width: 90%;">

                <i class="fa-solid fa-floppy-disk"></i>
                Save Attendance

            </button>

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

            <!-- CLASS FILTER -->
            <div class="dropdowns">

                <select id="attendence-class" class="select-custom classFilter">

                    <option value="All" disabled selected>All Classes</option>

                    <?php include "classDropdown.php"; ?>

                </select>

                <i class="fa-solid fa-chevron-down"></i>

            </div>

            <!-- SECTION DROPDOWN -->
            <div class="dropdowns">
                <select name="ssection" id="desktopSectionFilter" class="select-custom sectionDropdown" required>
                    <option value="All" selected disabled>Select Class First</option>
                    <?php include "sectionDropdown.php" ?>
                </select>
                <i class="fa-solid fa-chevron-down"></i>
            </div>

            <button type="button" class="btn btn-primary" onclick="loadStudentsAttendence()"><i class="fa-solid fa-rotate"></i> Load Students</button>

        </div>

        <!-- Mobile Filter bottom-sheet trigger -->
        <button class="mobile-filter-trigger" style="width: 100%;">
            <i class="fa-solid fa-sliders"></i>
            <span>Filters</span>
        </button>

    </section>

    <!-- ATTENDANCE FORM -->

    <section class="student-record attendance glass-card" id="studentCard" style="display: none; padding: 20px;">
        <div class="table-scroll attendance">
            <form id="attendence-form" action="save_attendance.php" method="POST">
                <input type="hidden" id="attendanceDateHidden" name="attendance_date" value="<?php echo date('Y-m-d'); ?>">

                <table class="attendance">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student Name</th>
                            <th>Remarks</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
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
    include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/confirmation-dialogue-box.php";
    ?>

    <!-- TOAST -->
    <div class="toast-container" id="toastContainer"></div>

</main>

</div>

<!-- FLOATING FILTER BOTTOM SHEET (MOBILE ONLY) -->
<div class="bottom-sheet-overlay" id="bottomSheetOverlay">

    <div class="bottom-sheet">

        <div class="bottom-sheet-header">
            <h3>Attendence Filter</h3>
            <button onclick="closeAttendanceFilter()" class="btn-action close-btn" id="closeBottomSheet"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <div class="bottom-sheet-body">

            <!-- FOR DATE -->
            <div class="form-group">
                <div class="form-label">Date</div>

                <!-- DATE -->
                <input type="date" id="attendanceDateMobile" class="select-custom" value="<?php echo date('Y-m-d'); ?>">

            </div>

            <div class="form-group">
                <span class="form-label">Class</span>

                <!-- CLASS FILTER -->
                <div class="dropdowns">

                    <select id="mobile-attendance-class" class="select-custom classFilter">

                        <option value="All" disabled selected>All Classes</option>

                        <?php include "classDropdown.php"; ?>

                    </select>

                    <i class="fa-solid fa-chevron-down"></i>

                </div>

            </div>
            <div class="form-group">

                <span class="form-label">Section</span>

                <!-- SECTION DROPDOWN -->
                <div class="dropdowns">
                    <select name="ssection" id="mobileAttendanceSection" class="select-custom sectionDropdown" required>
                        <option value="All" selected disabled>Select Class First</option>
                        <?php include "sectionDropdown.php" ?>
                    </select>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>

            </div>


            <div style="display:flex; gap:12px; margin-top:8px;">
                <button type="button" class="btn btn-primary loadStudentAttendence" id="" style="flex:1;">Load Students</button>
                <button onclick="closeAttendanceFilter()" class="btn btn-icon" id="clearMobileFiltersBtn" style="width:44px; font-size: 14px;"><i class="fa-solid fa-trash-can"></i></button>
            </div>

        </div>
    </div>
</div>

<!-- // include js -->
<script src="/school_management_system/assets/js/script.js"></script>
<script src="/school_management_system/assets/js/attendance.js"></script>


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
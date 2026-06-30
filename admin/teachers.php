<?php

// session_start();

// ROLE BASED AUTHENTICATION
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/admin/admin_auth.php";

// include sidebar
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/admin/admin_sidebar.php";

// include db
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

?>

<!-- MAIN CONTENT -->
<main class="main-content">

    <!-- topbar -->
    <header class="topbar glass-card">

        <div class="topbar-title">

            <button id="sidebarCollapseBtn" class="sidebar-toggle-btn">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="header-text">
                <h2>Teachers Records</h2>
                <p>Search, filter, add, edit, and manage teacher details efficiently.</p>
            </div>

        </div>

        <div class="topbar-btns">

            <button class="btn btn-primary add-btn" id="Add_teacher_btn">
                <i class="fa-solid fa-plus-circle"></i>
                <span>Add Teacher</span>
            </button>

            <!-- <button class="btn-icon">
                <i class="fa-solid fa-moon"></i>
            </button> -->

            <button class="btn btn-excel">
                <i class="fa-solid fa-file-excel"></i>
                <span>Excel Export</span>
            </button>

        </div>

    </header>

    <div class="main-content-scrollable">

        <!-- FILTERS RIBBON -->
        <section class="btn-group glass-card" style="margin-bottom: 12px;">

            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Search by ID, name, email...">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>

            <div class="filter-group">

                <div class="dropdowns" id="">

                    <select name="" id="desktopClassFilter" class="select-custom classFilter">
                        <option value="All">All Classes</option>
                        <?php include "classDropdown.php" ?>
                    </select>
                    <i class="fa-solid fa-chevron-down"></i>

                </div>

                <!-- SECTION DROPDOWN -->
                <div class="dropdowns">
                    <select name="" id="desktopSectionFilter" class="select-custom sectionDropdown" required>
                        <option disabled selected value="All">Select Class First</option>
                    </select>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>

                <div class="dropdowns">
                    <select name="" class="select-custom" id="desktopGenderFilter">
                        <option value="All" selected>All Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>

                <!-- RESET FILTER BUTTON -->
                <button title="Reset Filter" class="btn btn-icon" onclick="resetFilter()"><i class="fa-solid fa-filter-circle-xmark"></i></button>

            </div>

            <!-- Mobile Filter bottom-sheet trigger -->
            <button class="mobile-filter-trigger">
                <i class="fa-solid fa-sliders"></i>
                <span>Filters</span>
            </button>

        </section>

        <section class="teacher-record glass-card">

            <!-- TABLE FOR BIG SCREENS -->
            <div class="table-scroll desktop">
                <table id="teacherTable">
                    <!-- TABLE GENERATED DYNAMICALLY BY JS AND PHP -->
                </table>
            </div>

            <!-- CARDS FOR SMALL SCREEN -->
            <div id="teacherCards" class="student-cards">
                <!-- CARD GENERATED DYNAMICALLY BY JS AND PHP -->
            </div>

            <!-- PAGINATION -->
            <div class="pagination-wrapper" id="desktop-pagination">

                <div class="pagination-info"></div>
                <div id="pagination"></div>

            </div>

        </section>

    </div>

    <!-- ADD STUDENT MODAL -->
    <?php
    // for add student
    include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/admin/teacher-form.php";

    // for view teacher data
    include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/admin/view_teacher_record_modal.php";

    // confirmation dialogue box
    include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/confirmation-dialogue-box.php";

    // include floating filter for small screen
    include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/floating_filter.php";

    ?>

    <!-- TOAST NOTIFICATIONS CONTAINER -->
    <div class="toast-container" id="toastContainer"></div>

</main>
</div>

<!-- FOR SMALL SCREENS ADD FIXED BUTTON -->
<button class="btn-primary add-mobile-btn" id="Add_btn">
    <i class="fa-solid fa-plus-circle"></i>
</button>

<!-- // include js -->
<script src="/school_management_system/assets/js/script.js"></script>
<script src="/school_management_system/assets/js/teacher.js"></script>
<?php if (isset($_SESSION['toast'])) { ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            showToast(
                "<?= $_SESSION['toast']['message'] ?>",
                "<?= $_SESSION['toast']['type'] ?>",
                "<?= $_SESSION['toast']['title'] ?>"
            );
        });
    </script>
<?php unset($_SESSION['toast']);
} ?>

</body>

</html>
<?php

session_start();

// include sidebar
include $_SERVER['DOCUMENT_ROOT'] . "/student_management_system/includes/sidebar.php";

// include db
include $_SERVER['DOCUMENT_ROOT'] . "/student_management_system/config/connection.php";

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
                <h2>Student Records</h2>
                <p>Search, filter, add, edit, and manage student details efficiently.</p>
            </div>

        </div>
        <div class="topbar-btns">

            <button class="btn btn-primary add-btn" id="Add_btn">
                <i class="fa-solid fa-plus-circle"></i>
                <span>Add Student</span>
            </button>

            <!-- <button class="btn-icon">
                <i class="fa-solid fa-moon"></i>
            </button> -->

            <button class="btn btn-excel">
                <i class="fa-solid fa-file-excel"></i>
                <span>Excel Export</span>
            </button>

            <!-- USER PROFILE DROPDOWN CONTAINER -->
            <div class="user-profile-container">
                <button class="profile-trigger-btn" id="profileTrigger" aria-label="Open user menu">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80" alt="User Profile" class="user-avatar">
                </button>

                <div class="profile-dropdown-menu" id="profileDropdown">
                    <div class="dropdown-header">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80" alt="User Profile" class="dropdown-avatar">
                        <div class="user-info">
                            <h4>Alex Morgan</h4>
                            <p>alex.morgan@example.com</p>
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

        <section class="student-record glass-card">

            <!-- TABLE FOR BIG SCREENS -->
            <div class="table-scroll">
                <table id="studentTable">
                    <!-- TABLE GENERATED DYNAMICALLY BY JS AND PHP -->
                </table>
            </div>

            <!-- CARDS FOR SMALL SCREEN -->
            <div id="studentCards" class="student-cards">
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
    include $_SERVER['DOCUMENT_ROOT'] . "/student_management_system/includes/student-form.php";

    // confirmation dialogue box
    include $_SERVER['DOCUMENT_ROOT'] . "/student_management_system/includes/confirmation-dialogue-box.php";

    // include floating filter for small screen
    include $_SERVER['DOCUMENT_ROOT'] . "/student_management_system/includes/floating_filter.php";

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
<script src="/student_management_system/assets/js/script.js"></script>
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
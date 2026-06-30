<?php

include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/student/student_auth.php";

include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/student/student_sidebar.php";

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
                <h2>Student Records</h2>
                <p>Search, filter, add, edit, and manage student details efficiently.</p>
            </div>

        </div>
        <div class="topbar-btns">

            <!-- INCLUDE PROFILE CONTAINER -->
            <div id="desktop-container">
                <?php include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/profile-container.php"; ?>
            </div>

        </div>

    </header>

    <div class="main-content-scrollable">

        <!-- 2. Summary Cards Grid (Total Days, Present Days, Absent Days, Percentage) -->
        <section class="dashboard-grid-metrics" style=" margin-bottom: 18px;">

            <div class="glass-card metric-card">
                <div class="metric-details">
                    <p class="metric-title">Total School Days</p>
                    <h3 id="statTotalDays" class="metric-value">220</h3>
                </div>
                <div class="metric-icon" style="background: var(--primary-gradient);">
                    <i class="fa-solid fa-school"></i>
                </div>
            </div>

            <div class="glass-card metric-card">
                <div class="metric-details">
                    <p class="metric-title">Present Days</p>
                    <h3 id="statPresentDays" class="metric-value"">200</h3>
            </div>
            <div class=" metric-icon" style="background: linear-gradient(135deg, #2a9d8f, #059669);">
                        <i class="fa-solid fa-calendar-check"></i>
                </div>
            </div>

            <div class="glass-card metric-card">
                <div class="metric-details">
                    <p class="metric-title">Absent Days</p>
                    <h3 id="statAbsentDays" class="metric-value">20</h3>
                </div>
                <div class="metric-icon" style="background: linear-gradient(135deg, #e76f51, #c2410c);">
                    <i class="fa-solid fa-calendar-times"></i>
                </div>
            </div>

            <div class="glass-card metric-card">
                <div class="metric-details">
                    <p class="metric-title">Attendance %</p>
                    <h3 id="statPercentage" class="metric-value">91%</h3>
                </div>
                <div class="metric-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                    <i class="fa-solid fa-percent"></i>
                </div>
            </div>

        </section>

        <!-- 3. Attendance Percentage Progress Card -->
        <section class="glass-card progress-section-card" style=" margin-bottom: 18px;">
            <div class="progress-card-header">
                <h3>Overall Attendance Status</h3>
                <span class="progress-percentage-label" id="progressPctText"></span>
            </div>
            <div class="progress-track">
                <div class="progress-fill" id="progressFillBar"></div>
            </div>
        </section>

        <!-- 4. Interactive Filters Bar -->
        <section class="btn-group glass-card" style="margin-bottom: 18px;">

            <div style="display:flex; gap: 5px;">

                <!-- Month Filter Dropdown -->
                <div class="dropdowns">
                    <select class="select-custom" id="monthFilter" onchange="applyFilters()">
                        <option value="All">All Months</option>
                    </select>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>

                <!-- Year Filter Dropdown -->
                <div class="dropdowns">
                    <select class="select-custom" id="yearFilter" onchange="applyFilters()">
                        <option value="All">All Years</option>
                    </select>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>

            </div>


            <div style="display: flex; gap: 8px;">

                <!-- Table / Calendar Switch Button View toggles -->
                <div class="view-switcher">

                    <!-- FOR TABLE VIEW -->
                    <button class="switch-btn active" id="btnTableView" onclick="switchView('table')">
                        <i class="fa-solid fa-list-check"></i> Table View
                    </button>

                    <!-- fOR CARD VIEW -->
                    <button class="switch-btn" id="btnCalendarView" onclick="switchView('calendar')">
                        <i class="fa-solid fa-calendar-days"></i> Calendar View
                    </button>

                </div>

                <!-- Export report CSV tool -->
                <!-- <button class="btn btn-primary" onclick="">
                    <i class="fa-solid fa-file-arrow-down"></i> Report Nikalein
                </button> -->
            </div>
        </section>

        <!-- 5. Attendance History Table & Calendar Section -->
        <section class="glass-card table-section-card">

            <!-- Table View Mode -->
            <div class="table-scroll" id="tableViewContainer">
                <table class="student-record attendance" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Day</th>
                            <th>Status</th>
                            <th>Remarks/Reason</th>
                        </tr>
                    </thead>
                    <tbody id="attendanceTableBody">
                        <!-- JS is table data rows dynamically inject karega -->
                    </tbody>
                </table>

                <!-- Repaired card configuration layout block for mobile screens -->
                <div class="mobile-card-container" id="mobileCardContainer" style="display: none;">
                    <!-- JS is mobile cards dynamically inject karega -->
                </div>
            </div>

            <!-- Monthly Calendar View Mode -->
            <div class="calendar-view-container" id="calendarViewContainer" style="margin: 20px;">
                <div class="calendar-header-row">
                    <div class="calendar-title" id="calendarMonthTitle"></div>
                    <div class="calendar-legend">
                        <div class="legend-item"><span class="legend-color" style="background: var(--color-present)"></span> Present</div>
                        <div class="legend-item"><span class="legend-color" style="background: var(--color-absent)"></span> Absent</div>
                        <div class="legend-item"><span class="legend-color" style="background: var(--color-late)"></span> Late</div>
                        <div class="legend-item"><span class="legend-color" style="background: var(--color-leave)"></span> Leave</div>
                    </div>
                </div>

                <div class="calendar-grid" id="calendarCellsContainer">
                    <!-- Calendar days dynamically populate honge -->
                </div>
            </div>

            <div class="pagination-wrapper">

                <div class="pagination-info" id="paginationInfo">
                </div>

                <div class="pagination-buttons" id="paginationContainer">

                </div>

            </div>

        </section>

    </div>

</main>

<!-- CUSTOM JS -->
<script src="/school_management_system/assets/js/script.js"></script>
<script src="/school_management_system/assets/js/student-attendance.js"></script>

</body>

</html>
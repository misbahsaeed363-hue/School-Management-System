<?php
// include sidebar
include_once "sidebar.php";

// include db
include_once "connection.php";

// <!-- ADD NEW SECTION MODAL -->
include "add_section_modal.php";

?>
<!-- MAIN CONTENT -->
<main class="main-content">

    <!-- topbar -->
    <header class="topbar glass-card">
        <div class="topbar-title">
            <h2>Classes & Sections</h2>
            <p>Manage academic classes and sections.</p>
        </div>
        <div class="topbar-btns">

            <button class="btn btn-primary" id="Add_section_btn">
                <i class="fa-solid fa-plus-circle"></i>
                <span>Add Section</span>
            </button>

            <button class="btn-icon">
                <i class="fa-solid fa-moon"></i>
            </button>

            <button class="btn-icon"><i class="fa-solid fa-rotate"></i></button>

            <button class="btn btn-excel">
                <i class="fa-solid fa-file-excel"></i>
                <span>Excel Export</span>
            </button>

        </div>
    </header>

    <!-- SCROLLABLE CONTENT -->
    <div class="main-content-scrollable">

        <!-- TOP SECTION: Small Statistics Cards -->
        <section class="metrics-grid">

            <div class="metrics-card">
                <div class="metrics-icon">
                    <i class="fa-solid fa-school"></i>
                </div>
                <div class="metrics-info">
                    <h4>Total Classes</h4>
                    <p>
                        <!-- For Total Classes -->
                        <?php
                        $sql1 = "SELECT COUNT(*) AS total_classes FROM classes";
                        $result1 = $conn->query($sql1) or die("Query Unsuccessfull");

                        $row1 = $result1->fetch_assoc();

                        echo $row1['total_classes'];

                        ?>
                    </p>
                </div>
            </div>

            <div class="metrics-card glass-card">
                <div class="metrics-icon" style="background: var(--gradient-1)">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div class="metrics-info">
                    <h4>Total Sections</h4>
                    <p>
                        <!-- For Total Sections -->
                        <?php
                        $sql2 = "SELECT COUNT(*) AS total_sections FROM sections";
                        $result2 = $conn->query($sql2) or die("Query Unsuccessfull");

                        $row2 = $result2->fetch_assoc();

                        echo $row2['total_sections'];
                        ?>
                    </p>
                </div>
            </div>

            <div class="metrics-card">
                <div class="metrics-icon" style="background: var(--gradient-2)">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="metrics-info">
                    <h4>Total Students</h4>
                    <p>
                        <!-- For Total Students -->
                        <?php

                        $sql3 = "SELECT COUNT(*) AS total_students FROM students";
                        $result3 = $conn->query($sql3) or die("Query Unsuccessfull");

                        $row3 = $result3->fetch_assoc();

                        echo $row3['total_students'];
                        ?>
                    </p>
                </div>
            </div>

        </section>

        <!-- MIDDLE SECTION: Horizontal Bar Charts -->
        <section>
            <div class="chart-section glass-card">

                <div class="chart-header">
                    <div class="chart-title">
                        <h3>Students Per Class Analytics</h3>
                    </div>
                </div>

                <div class="horizontal-bar-chart">

                    <?php

                    $sql4 = "SELECT * FROM classes";
                    $result4 = $conn->query($sql4);

                    if ($result4->num_rows > 0) {
                        while ($row4 = $result4->fetch_assoc()) {
                            $class_id = $row4['id'];

                    ?>

                            <div class="chart-row">

                                <div class="chart-label">
                                    Class
                                    <?php echo $row4['id'] ?>

                                </div>

                                <?php

                                // TO GET CLASS CAPACITY
                                $sql5 = "SELECT class_id, SUM(capacity) AS capacity
                            FROM sections
                            GROUP BY class_id";
                                $result5 = $conn->query($sql5);

                                $row5 = $result5->fetch_assoc();

                                $sql7 = "SELECT class_id, COUNT(*) AS total_students
                            FROM students
                            JOIN sections
                            ON students.section_id = sections.sec_id
                            WHERE class_id = '$class_id'
                            ";
                                $result7 = $conn->query($sql7);
                                $row7 = $result7->fetch_assoc();
                                $total_students = $row7['total_students'];
                                $class_capacity = $row5['capacity'];

                                ?>

                                <div class="chart-track">
                                    <?php

                                    $percent = ($class_capacity > 0)
                                        ? ($total_students / $class_capacity * 100)
                                        : 0;

                                    ?>
                                    <div class="chart-fill" style="width: <?php echo $percent ?>%"></div>
                                </div>

                                <div class="chart-value">
                                    <?php echo $total_students; ?>
                                    Students
                                </div>

                            </div>

                    <?php
                        }
                    }
                    ?>

                </div>

            </div>
        </section>



        <!-- Bottom SECTION: Class card and filters -->
        <section class="glass-card class-page-bottom">

            <!-- FILTERS ROW -->
            <div class="btn-group">

                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Search by ID, name, email...">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>

                <div class="filter-group">

                    <div class="dropdowns" id="">

                        <select name="" id="classFilter" onchange="filterTable()" class="select-custom">
                            <?php include "classDropdown.php" ?>
                        </select>
                        <i class="fa-solid fa-chevron-down"></i>

                    </div>

                    <div class="dropdowns">
                        <select name="" class="select-custom" id="genderFilter" onchange="filterTable()">
                            <option value="All" selected>All Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>

                    <!-- SECTION DROPDOWN -->
                    <div class="dropdowns">
                        <select name="" class="select-custom sectionDropdown" required>
                            <option disabled selected>Select Class First</option>
                            <?php include "sectionDropdown.php" ?>
                        </select>
                    </div>

                    <div class="">
                        <button class="button">Apply Filters</button>
                    </div>

                </div>

            </div>

            <!-- CLASSES CARDS -->
            <div class="classes-card-grid">
                <?php
                if ($result4->num_rows > 0) {

                    $result4->data_seek(0);

                    while ($row4 = $result4->fetch_assoc()) {
                        $class_id = $row4['id'];

                ?>
                        <!-- CLASS CARD -->
                        <div class="class-card" data-card-class="<?php echo $class_id; ?>">

                            <!-- CARD TOP -->
                            <div class="card-top">

                                <div class="class-card-name">Class <?php echo $row4['id'] ?></div>

                                <span class="capacity-badge"></span>

                            </div>

                            <!--  SECTION SWITCHER -->
                            <div class="card-switcher-container">

                                <span class="switcher-label">Sections:</span>

                                <?php
                                $sql6 = "SELECT * FROM sections
                                    WHERE class_id = '$class_id'";
                                $result6 = $conn->query($sql6) or die("Query unsuccessfull");
                                $first = true;

                                while ($row6 = $result6->fetch_assoc()) {

                                    $activeClass = '';

                                    if ($first) {
                                        $activeClass = 'active';
                                        $first = false;
                                    }

                                ?>
                                    <button class="section-switch-btn <?php echo $activeClass; ?>" data-section-id="<?php echo $row6['sec_id']; ?>" data-class-id="<?php echo $class_id; ?>"><?php echo $row6['section_name'] ?></button>
                                <?php
                                }

                                ?>


                            </div>

                            <!-- CARD DYNAMIC CONTAINER -->
                            <div class="card-dynamic-content">


                                <!-- PROGRESS CONTAINER -->
                                <div class="card-progress-container">

                                    <div class="card-progress-meta">
                                        <span>Section Capacity</span>
                                        <span></span>
                                    </div>

                                    <div class="card-progress-track">
                                        <div class="card-progress-fill"></div>
                                    </div>

                                </div>

                                <!-- TEACHER INFO BOX -->
                                <div class="card-teacher-box">
                                    <div class="teacher-box-label">
                                        <i class="fa-solid fa-chalkboard-user"></i>
                                        <span class="teacher-box-label">Class Teacher</span>
                                    </div>
                                    <div>
                                        <span class="class-teacher"></span>
                                    </div>
                                </div>

                                <!-- CARD STATICS ROW -->
                                <div class="card-stat-row">

                                    <!-- CARD STATICS BOX -->
                                    <div class="card-stat-box" style="border-right: 2px solid var(--card-inner-border);">

                                        <span class="card-stat-label">Students</span>
                                        <div class="card-stat-value">
                                            <i class="fa-solid fa-graduation-cap"></i>
                                            <span class="total-student-card"></span>
                                        </div>

                                    </div>

                                    <div class="card-stat-box">

                                        <span class="card-stat-label">Academic Load</span>
                                        <div class="card-stat-value">
                                            <i class="fa-solid fa-book"></i>
                                            <span class="total-subjects-card"></span>
                                        </div>

                                    </div>

                                </div>

                                <!-- CARD BUTTON ROW -->
                                <div class="card-buttons-row">

                                    <button class="btn btn-secondary section-detail-trigger" data-class-id="<?php echo $class_id; ?>">
                                        <i class="fa-solid fa-layer-group"></i>
                                        Details
                                    </button>

                                    <button class="btn btn-secondary">
                                        <i class="fa-solid fa-user-graduate"></i>
                                        View Students
                                    </button>

                                </div>

                                <!-- Subject & Teachers list Button -->
                                <button class="btn btn-primary subject-teacher-list-trigger" data-class-id="<?php echo $class_id; ?>" id="teacherlistBtn">
                                    <i class="fa-solid fa-chalkboard-user"></i>
                                    Subject Teacher List
                                </button>

                            </div>

                        </div>

                <?php
                    }
                }
                ?>
            </div>

        </section>

    </div>

    <?php

    include "section_Detail_modal.php";
    include "subject_list_modal.php"

    ?>

</main>

</div>

<!-- // include js -->
<script src="assests/js/script.js"></script>

</body>
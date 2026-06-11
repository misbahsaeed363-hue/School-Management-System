<?php

session_start();

include_once "sidebar.php";
// include db
include $_SERVER['DOCUMENT_ROOT'] . "/student_management_system/config/connection.php";

?>

<main class="main-content">

    <header class="topbar glass-card">

        <div class="topbar-title">
            <h2>Attendance Report</h2>
            <p>View and analyze attendance records.</p>
        </div>

        <div class="topbar-btns">

            <a href="attendance.php" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i>
                Mark Attendance
            </a>

        </div>

    </header>

    <!-- FILTERS -->

    <section class="btn-group glass-card">

        <div class="search-box">

            <input
                type="text"
                id="reportSearch"
                placeholder="Search Student">

            <i class="fa-solid fa-magnifying-glass"></i>

        </div>

        <div class="filter-group">

            <input
                type="date"
                id="dateFilter"
                class="select-custom">

            <div class="dropdowns">

                <select
                    id="classFilter"
                    class="select-custom">

                    <option value="All">
                        All Classes
                    </option>

                    <?php include "classDropdown.php"; ?>

                </select>

                <i class="fa-solid fa-chevron-down"></i>

            </div>

        </div>

    </section>

    <!-- REPORT TABLE -->

    <section class="student-record glass-card">

        <div class="table-scroll">

            <table id="reportTable">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Student</th>
                        <th>Class</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Percentage</th>

                    </tr>

                </thead>

                <tbody>

                    <?php

                    $sql = "

                    SELECT

                    attendance.*,
                    students.name,
                    students.images,
                    sections.section_name,
                    classes.class_name,
                    classes.id as classid

                    FROM attendance

                    JOIN students
                    ON attendance.student_id = students.sid

                    JOIN sections
                    ON students.section_id = sections.sec_id

                    JOIN classes
                    ON sections.class_id = classes.id

                    ORDER BY attendance.attendance_date DESC

                    ";

                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {

                        $sid = $row['student_id'];

                        $total = mysqli_num_rows(

                            mysqli_query(

                                $conn,

                                "SELECT *
                                FROM attendance
                                WHERE student_id='$sid'"

                            )

                        );

                        $present = mysqli_num_rows(

                            mysqli_query(

                                $conn,

                                "SELECT *
                                FROM attendance
                                WHERE student_id='$sid'
                                AND status='Present'"

                            )

                        );

                        $percentage = 0;

                        if ($total > 0) {

                            $percentage =
                                round(
                                    ($present / $total) * 100
                                );
                        }

                    ?>

                        <tr
                            class="report-row"
                            data-class="<?php echo $row['classid']; ?>"
                            data-date="<?php echo $row['attendance_date']; ?>">

                            <td>
                                <?php echo $sid; ?>
                            </td>

                            <td>

                                <div style="display:flex;align-items:center;gap:10px;">

                                    <img
                                        src="<?php echo $row['images']; ?>"
                                        class="student-img">

                                    <?php echo $row['name']; ?>

                                </div>

                            </td>

                            <td>

                                <?php
                                echo $row['class_name']
                                    . " - "
                                    . $row['section_name'];
                                ?>

                            </td>

                            <td>
                                <?php echo $row['attendance_date']; ?>
                            </td>

                            <td>

                                <?php

                                $status =
                                    strtolower($row['status']);

                                ?>

                                <span class="attendance-badge <?php echo $status; ?>">

                                    <?php echo $row['status']; ?>

                                </span>

                            </td>

                            <td>

                                <?php echo $percentage; ?>%

                            </td>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </section>

</main>

</div>

<script>

    // SEARCH

    document
        .getElementById("reportSearch")
        .addEventListener("keyup", function() {

            let value =
                this.value.toLowerCase();

            document
                .querySelectorAll(".report-row")
                .forEach(row => {

                    row.style.display =
                        row.innerText
                        .toLowerCase()
                        .includes(value)
                        ?
                        ""
                        :
                        "none";

                });

        });

    // CLASS FILTER

    document
        .getElementById("classFilter")
        .addEventListener("change", function() {

            let selected =
                this.value;

            document
                .querySelectorAll(".report-row")
                .forEach(row => {

                    if (
                        selected === "All" ||
                        row.dataset.class === selected
                    ) {

                        row.style.display = "";

                    } else {

                        row.style.display = "none";

                    }

                });

        });

    // DATE FILTER

    document
        .getElementById("dateFilter")
        .addEventListener("change", function() {

            let date =
                this.value;

            document
                .querySelectorAll(".report-row")
                .forEach(row => {

                    if (
                        date === "" ||
                        row.dataset.date === date
                    ) {

                        row.style.display = "";

                    } else {

                        row.style.display = "none";

                    }

                });

        });

</script>

</body>

</html>
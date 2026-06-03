<?php

session_start();

// include sidebar
include_once "sidebar.php";

// include db
include_once "connection.php";

?>

<!-- MAIN CONTENT -->
<main class="main-content">

    <!-- topbar -->
    <header class="topbar glass-card">
        <div class="topbar-title">
            <h2>Student Records</h2>
        </div>
        <div class="topbar-btns">

            <button class="btn btn-primary" id="Add_btn">
                <i class="fa-solid fa-plus-circle"></i>
                <span>Add Student</span>
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

    <!-- FILTERS RIBBON -->
    <section class="btn-group glass-card" style="margin-bottom: 12px;">

        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Search by ID, name, email...">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>

        <div class="filter-group">

            <div class="dropdowns" id="">

                <select name="" id="" onchange="filterTable()" class="select-custom classFilter">
                    <option value="All">All Classes</option>
                    <?php include "classDropdown.php" ?>
                </select>
                <i class="fa-solid fa-chevron-down"></i>

            </div>

            <!-- SECTION DROPDOWN -->
            <div class="dropdowns">
                <select name="" id="sectionFilter" onchange="filterTable()" class="select-custom sectionDropdown" required>
                    <option disabled selected value="All">Select Class First</option>
                    <?php include "sectionDropdown.php" ?>
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

            <div class="">
                <button class="button" onclick="resetFilter()">Reset Filters</button>
            </div>

        </div>
    </section>

    <section class="student-record glass-card">

        <div class="table-scroll">
            <table id="studentTable">

                <thead>
                    <tr>
                        <th>id</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Contact Details</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Class</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    <!-- for read data -->
                    <?php

                    $sql1 = "SELECT * FROM students
                    JOIN sections ON students.section_id = sections.sec_id";
                    $result1 = $conn->query($sql1) or die("Query unsuccessful");

                    if ($result1->num_rows > 0) {
                        while ($row1 = $result1->fetch_assoc()) {
                    ?>

                            <tr class="student-table-row">
                                <td class="student-id-col" data-student-id="<?php echo $row1['sid'] ?>"><?php echo $row1['sid'] ?></td>
                                <td>
                                    <img class="student-img" src="<?php echo $row1['images'] ?>" alt="">
                                </td>
                                <td>
                                    <h4><?php echo $row1['name'] ?></h4>
                                </td>
                                <td>
                                    <div class="contact-cell">
                                        <h5><?php echo $row1['email'] ?></h5>
                                        <span><?php echo $row1['phone'] ?></span>
                                    </div>
                                </td>
                                <td><?php echo $row1['gender'] ?></td>
                                <td><?php echo $row1['address'] ?></td>
                                <td><?php echo $row1['class_id']; ?> -
                                    <?php echo $row1['section_name']; ?></td>
                                <td>
                                    <span class="status active"><?php echo $row1['status'] ?></span>
                                </td>
                                <td>
                                    <div class="btns-action">
                                        <button class="btn-action edit" title="Edit"><i class="fa-solid fa-pen"></i></button>
                                        <a class="btn-action delete delete-btn" href="deletephp.php?delete=<?php echo $row1['sid']; ?>" title="Delete"><i class="fa-solid fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>

                    <?php
                        }
                    }

                    ?>

                </tbody>

            </table>

        </div>

    </section>

    <!-- ADD STUDENT MODAL -->
    <?php
    // for add student
    include_once "student-form.php";

    // confirmation dialogue box
    include "confirmation-dialogue-box.php"
    ?>

    <!-- TOAST NOTIFICATIONS CONTAINER -->
    <div class="toast-container" id="toastContainer"></div>

</main>
</div>

<!-- // include js -->
<script src="assests/js/script.js"></script>
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
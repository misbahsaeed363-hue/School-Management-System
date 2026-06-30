<?php

// ROLE BASED AUTHENTICATION
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/admin/admin_auth.php";

// include sidebar
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/admin/admin_sidebar.php";

// include connection
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

// --- SQL QUERIES FOR METRICS ---

// 1. Total Students (Primary Key: sid)
$totalStudentsQuery = "SELECT COUNT(sid) as total FROM students";
$totalStudentsResult = $conn->query($totalStudentsQuery);
$totalStudents = $totalStudentsResult ? $totalStudentsResult->fetch_assoc()['total'] : 0;

// 2. Active Students
$activeStudentsQuery = "SELECT COUNT(sid) as total FROM students WHERE status = 'Active'";
$activeStudentsResult = $conn->query($activeStudentsQuery);
$activeStudents = $activeStudentsResult ? $activeStudentsResult->fetch_assoc()['total'] : 0;

// 3. Total Classes 
$totalClassesQuery = "SELECT COUNT(id) as total FROM classes";
$totalClassesResult = $conn->query($totalClassesQuery);
$totalClasses = $totalClassesResult ? $totalClassesResult->fetch_assoc()['total'] : 0;

// 4. Total Sections
$totalSectionsQuery = "SELECT COUNT(sec_id) as total FROM sections";
$totalSectionsResult = $conn->query($totalSectionsQuery);
$totalSections = $totalSectionsResult ? $totalSectionsResult->fetch_assoc()['total'] : 0;

// 5. Total Teachers 
$totalTeachersQuery = "SELECT COUNT(tid) as total FROM teachers";
$totalTeachersResult = $conn->query($totalTeachersQuery);
$totalTeachers = $totalTeachersResult ? $totalTeachersResult->fetch_assoc()['total'] : 0;


// --- SQL QUERIES FOR CHARTS ---

// 1. Class-wise Student Count (Bar Chart Data)
$classWiseQuery = "SELECT c.class_name, COUNT(s.sid) as student_count 
                   FROM classes c 
                   LEFT JOIN sections sec ON sec.class_id = c.id
                   LEFT JOIN students s ON s.section_id = sec.sec_id 
                   GROUP BY c.id, c.class_name";
$classWiseResult = $conn->query($classWiseQuery);

$classNames = [];
$studentCounts = [];

if ($classWiseResult && $classWiseResult->num_rows > 0) {
    while ($row = $classWiseResult->fetch_assoc()) {
        $classNames[] = $row['class_name'];
        $studentCounts[] = $row['student_count'];
    }
}

// 2. Today's Attendance Summary 
$todayDate = date('Y-m-d');
$attendanceQuery = "SELECT status, COUNT(*) as count 
                    FROM attendance 
                    WHERE attendance_date = '$todayDate' 
                    GROUP BY status";
$attendanceResult = $conn->query($attendanceQuery);

$attendanceStats = ['Present' => 0, 'Absent' => 0, 'Late' => 0, 'Leave' => 0];
if ($attendanceResult && $attendanceResult->num_rows > 0) {
    while ($row = $attendanceResult->fetch_assoc()) {
        if (array_key_exists($row['status'], $attendanceStats)) {
            $attendanceStats[$row['status']] = $row['count'];
        }
    }
}
?>

<!-- Responsive Styles & Meta Tags -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    @media (max-width: 640px) {
        .main-content-scrollable {
            padding: 12px !important;
        }

        .dashboard-grid-metrics {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .glass-card {
            padding: 15px !important;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<main class="main-content">

    <header class="topbar glass-card">
        <div class="topbar-title">
            <button id="sidebarCollapseBtn" class="sidebar-toggle-btn">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="header-text">
                <h2>Admin Dashboard</h2>
                <p>Welcome back! Here's what's happening in your school today.</p>
            </div>
        </div>
    </header>

    <div class="main-content-scrollable" style="padding: 20px;">

        <!-- Metrics Section (Responsive Grid) -->
        <div class="dashboard-grid-metrics">

            <div class="glass-card metric-card">
                <div>
                    <p class="metric-title">Total Students</p>
                    <h3 class="metric-value"><?= $totalStudents ?></h3>
                </div>
                <div class="metric-icon icon-students">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
            </div>

            <div class="glass-card metric-card">
                <div>
                    <p class="metric-title">Active Students</p>
                    <h3 class="metric-value"><?= $activeStudents ?></h3>
                </div>
                <div class="metric-icon icon-active">
                    <i class="fa-solid fa-user-check"></i>
                </div>
            </div>

            <div class="glass-card metric-card">
                <div>
                    <p class="metric-title">Total Teachers</p>
                    <h3 class="metric-value"><?= $totalTeachers ?></h3>
                </div>
                <div class="metric-icon icon-teachers">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
            </div>

            <div class="glass-card metric-card metric-card">
                <div>
                    <p class="metric-title">Total Classes</p>
                    <h3 class="metric-value"><?= $totalClasses ?></h3>
                </div>
                <div class="metric-icon icon-classes">
                    <i class="fa-solid fa-school"></i>
                </div>
            </div>

            <div class="glass-card metric-card">
                <div>
                    <p class="metric-title">Total Sections</p>
                    <h3 class="metric-value"><?= $totalSections ?></h3>
                </div>
                <div class="metric-icon icon-sections">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
            </div>

        </div>

        <!-- Charts Section (Responsive Stack/Row) -->
        <div class="dashboard-grid-charts" style="margin-top: 18px;">

            <div class="glass-card" style="padding: 20px;" class="glass-card chart-card">
                <h4 class="chart-title">Students by Class</h4>
                <div class="chart-container-wrapper">
                    <canvas id="classChart"></canvas>
                </div>
            </div>

            <div class="glass-card" style="padding: 20px;" class="glass-card chart-card">
                <h4 class="chart-title">Today's Attendance Status</h4>
                <div class="chart-container-wrapper attendance-chart-wrapper">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>

        </div>

    </div>

    <!-- TOAST NOTIFICATIONS CONTAINER -->
    <div class="toast-container" id="toastContainer"></div>

</main>

</div>

<script src="/school_management_system/assets/js/script.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        // 1. Class Wise Bar Chart
        const classCtx = document.getElementById('classChart').getContext('2d');
        const classChart = new Chart(classCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($classNames); ?>,
                datasets: [{
                    label: 'Number of Students',
                    data: <?php echo json_encode($studentCounts); ?>,
                    backgroundColor: 'rgba(37, 99, 235, 0.7)',
                    borderColor: 'rgba(37, 99, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45,
                            autoSkip: true,
                            maxTicksLimit: 8
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // 2. Attendance Status Doughnut Chart
        const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
        const attendanceChart = new Chart(attendanceCtx, {
            type: 'doughnut',
            data: {
                labels: ['Present', 'Absent', 'Late', 'Leave'],
                datasets: [{
                    data: [
                        <?= $attendanceStats['Present'] ?>,
                        <?= $attendanceStats['Absent'] ?>,
                        <?= $attendanceStats['Late'] ?>,
                        <?= $attendanceStats['Leave'] ?>
                    ],
                    backgroundColor: [
                        '#10b981', // Present - Green
                        '#ef4444', // Absent - Red
                        '#f59e0b', // Late - Amber
                        '#64748b' // Leave - Slate Grey
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 15
                        }
                    }
                }
            }
        });

        const collapseBtn = document.getElementById("sidebarCollapseBtn");

        if (collapseBtn) {
            collapseBtn.addEventListener("click", () => {

                setTimeout(() => {
                    classChart.resize();
                    attendanceChart.resize();
                }, 350);

            });
        }

    });
</script>

<!-- FOR TOAST MESSAGE -->
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
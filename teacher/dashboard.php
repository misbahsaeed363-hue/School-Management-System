<?php
// ROLE BASED AUTHENTICATION
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/teacher/teacher_auth.php";

// include sidebar
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/teacher/teacher_sidebar.php";

// include db
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

?>

<!-- MAIN CONTENT -->

</div>

<!-- // include js -->
<script src="/school_management_system/assets/js/script.js"></script>
<script src="/school_management_system/assets/js/teacher-students.js"></script>
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
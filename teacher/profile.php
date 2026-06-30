<?php
// ROLE BASED AUTHENTICATION
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/teacher/teacher_auth.php";

// include sidebar
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/teacher/teacher_sidebar.php";

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
                <h2>My Profile</h2>
                <p>View assignments, update contact info and manage account credentials.</p>
            </div>

        </div>
        <div class="topbar-btns">

            <!-- Toggle Edit Mode Button -->
            <button class="btn btn-primary" id="editProfileBtn" onclick="enableEditMode()">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Edit Profile</span>
            </button>

            <div id="desktop-container">
                <!-- INCLUDE PROFILE CONTAINER -->
                <?php include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/profile-container.php"; ?>
            </div>

        </div>

    </header>

    <div class="main-content-scrollable">

        <form id="profileForm" onsubmit="saveProfileData(event)">
            <div class="profile-grid-layout">

                <!-- COLUMN 1: Profile Header Summary Card -->
                <div class="profile-side-card">

                    <!-- Profile picture wrapper -->
                    <div class="profile-wrapper">
                        <div class="card-picture">
                            <img src="" alt="Teacher Avatar" id="profileImgDisplay">
                            <div class="avatar-overlay" onclick="triggerImageUpload()">
                                <i class="fa-solid fa-camera"></i>
                                <span>Change Photo</span>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden File input -->
                    <input type="file" id="profile-image-input" accept="image/*" onchange="previewProfileImage(this)" disabled style="display: none;">

                    <h3 class="profile-teacher-name" id="sideCardName"></h3>
                    <span class="profile-teacher-role"></span>

                    <!-- read-only parameters -->
                    <div class="profile-meta-list">
                        <div class="meta-item">
                            <i class="fa-solid fa-id-badge"></i>
                            <div class="meta-content">
                                <span class="meta-label">Employee ID</span>
                                <span class="meta-value" id="sideCardTid"></span>
                            </div>
                        </div>

                        <div class="meta-item">
                            <i class="fa-solid fa-envelope"></i>
                            <div class="meta-content">
                                <span class="meta-label">Official Email</span>
                                <span class="meta-value" id="sideCardEmail"></span>
                            </div>
                        </div>

                        <div class="meta-item">
                            <i class="fa-solid fa-calendar-days"></i>
                            <div class="meta-content">
                                <span class="meta-label">Joining Date</span>
                                <span class="meta-value" id="sideCardDate"></span>
                            </div>
                        </div>

                        <div class="meta-item">
                            <i class="fa-solid fa-user-shield"></i>
                            <div class="meta-content">
                                <span class="meta-label">Role Category</span>
                                <span class="meta-value">Teacher / Academic</span>
                            </div>
                        </div>

                        <div class="meta-item">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <div class="meta-content">
                                <span class="meta-label">Qualification</span>
                                <span class="meta-value" id="sideCardQualification"></span>
                            </div>
                        </div>

                    </div>

                    <!-- Remove photo option trigger during edit state -->
                    <button type="button" class="remove-photo-btn" id="removePhotoBtn" onclick="removeProfilePhoto()" style="display: none; margin-top: 18px;">
                        <i class="fa-solid fa-trash-can"></i>
                        <span>Remove Photo</span>
                    </button>
                </div>

                <!-- COLUMN 2: Details Panels Stack -->
                <div>

                    <!-- Statistics Cards Strip -->
                    <div class="stats-summary-grid">
                        <div class="stat-badge-card">
                            <div class="stat-badge-icon">
                                <i class="fa-solid fa-landmark"></i>
                            </div>
                            <div class="stat-badge-details">
                                <span class="stat-badge-label">Assigned Classes</span>
                                <span class="stat-badge-number" id="assignedClasses"></span>
                            </div>
                        </div>

                        <div class="stat-badge-card">
                            <div class="stat-badge-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                                <i class="fa-solid fa-book-open"></i>
                            </div>
                            <div class="stat-badge-details">
                                <span class="stat-badge-label">Assigned Subjects</span>
                                <span class="stat-badge-number" id="assignedSubjects"></span>
                            </div>
                        </div>

                        <div class="stat-badge-card">
                            <div class="stat-badge-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                            <div class="stat-badge-details">
                                <span class="stat-badge-label">Total Students</span>
                                <span class="stat-badge-number" id="totalStudents"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information inner card -->
                    <div class="inner-form-card">
                        <div class="section-header">
                            <i class="fa-solid fa-address-card"></i>
                            <h3>Personal Information</h3>
                        </div>

                        <div class="form-grid">
                            <!-- Full Name (Locked) -->
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                <div class="form-control-wrapper">
                                    <input type="text" class="form-control" id="name" value="" disabled>
                                    <i class="fa-solid fa-lock lock-icon" title="Can only be edited by Admin"></i>
                                </div>
                            </div>

                            <!-- Email (Locked) -->
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <div class="form-control-wrapper">
                                    <input type="email" class="form-control" id="email" value="ali@gmail.com" disabled>
                                    <i class="fa-solid fa-lock lock-icon" title="Can only be edited by Admin"></i>
                                </div>
                            </div>

                            <!-- Phone (EDITABLE) -->
                            <div class="form-group">
                                <label class="form-label">Phone Number <span style="color: #2563eb; font-size:9px;">(Editable)</span></label>
                                <input type="tel" class="form-control" id="phone" value="" required disabled>
                            </div>

                            <!-- Gender (Locked) -->
                            <div class="form-group">
                                <label class="form-label">Gender</label>
                                <div class="form-control-wrapper">
                                    <input type="text" class="form-control" id="gender" value="" disabled>
                                    <i class="fa-solid fa-lock lock-icon" title="Can only be edited by Admin"></i>
                                </div>
                            </div>

                            <!-- Date Of Birth (Locked) -->
                            <div class="form-group">
                                <label class="form-label">Date Of Birth</label>
                                <div class="form-control-wrapper">
                                    <input type="date" class="form-control" id="dob" value="" disabled>
                                    <i class="fa-solid fa-lock lock-icon" title="Can only be edited by Admin"></i>
                                </div>
                            </div>

                            <!-- Account Status (Locked Info badge) -->
                            <div class="form-group">
                                <label class="form-label">Account Status</label>
                                <div class="form-control-wrapper">
                                    <input type="text"
                                        class="form-control"
                                        id="status"
                                        disabled>
                                    <i class="fa-solid fa-shield-halved lock-icon"></i>
                                </div>
                            </div>

                            <!-- Residential Address (EDITABLE) -->
                            <div class="form-group form-full">
                                <label class="form-label">Residential Address <span style="color: #2563eb; font-size:9px;">(Editable)</span></label>
                                <input type="text" class="form-control" id="address" value="Apartment 4B, Gulshan-e-Iqbal, Karachi" required disabled>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Experience</label>

                                <div class="form-control-wrapper">
                                    <input type="text"
                                        class="form-control"
                                        id="experience_years"
                                        disabled>

                                    <i class="fa-solid fa-lock lock-icon"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Marital Status</label>

                                <div class="form-control-wrapper">
                                    <input type="text" class="form-control" id="marital_status" disabled>
                                    <i class="fa-solid fa-lock lock-icon"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Salary</label>

                                <div class="form-control-wrapper">
                                    <input type="text"
                                        class="form-control"
                                        id="salary"
                                        disabled>

                                    <i class="fa-solid fa-lock lock-icon"></i>
                                </div>
                            </div>

                        </div>


                        <!-- Form Actions (Appears on edit state) -->
                        <div class="modal-footer" id="profileFormActions" style="display: none; padding-top: 16px; margin-top: 16px;">
                            <button class="btn cancel-btn" type="button" onclick="cancelEditMode()">Cancel</button>
                            <button class="btn btn-primary" type="submit">Save Changes</button>
                        </div>
                    </div>


                </div>

            </div>
        </form>

        <!-- Assigned Classes & Subjects Card (Read-Only list from Admin records) -->
        <div class="inner-form-card">
            <div class="section-header">
                <i class="fa-solid fa-book-bookmark"></i>
                <h3>Assigned Classes & Subjects</h3>
            </div>

            <div id="assignmentsList">
                <!-- GENERATED DYNAMICALLY BY JS AND PHP -->
            </div>

        </div>

    </div>
    <?php

    // confirmation dialogue box
    include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/confirmation-dialogue-box.php";

    // include floating filter for small screen
    include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/floating_filter.php";

    ?>

    <!-- TOAST NOTIFICATIONS CONTAINER -->
    <div class="toast-container" id="toastContainer"></div>

</main>
</div>

<!-- // include js -->
<script src="/school_management_system/assets/js/script.js"></script>
<!-- <script src="/school_management_system/assets/js/teacher-students.js"></script> -->
<script src="/school_management_system/assets/js/teacher-profile.js"></script>

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
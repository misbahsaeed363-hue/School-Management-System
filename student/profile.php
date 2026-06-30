<?php
// ROLE BASED AUTHENTICATION
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/student/student_auth.php";

// include sidebar
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/student/student_sidebar.php";

// include db
include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/config/connection.php";

?>

<!-- MAIN CONTENT -->
<main class="main-content">

    <!-- Topbar -->
    <header class="topbar glass-card">

        <div class="topbar-title">

            <button id="sidebarCollapseBtn" class="sidebar-toggle-btn">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="header-text">
                <h2>My Profile</h2>
                <p>View academic details, update contact information and manage your account.</p>
            </div>

        </div>

        <div class="topbar-btns">

            <button class="btn btn-primary"
                id="editProfileBtn"
                onclick="enableEditMode()">

                <i class="fa-solid fa-pen-to-square"></i>
                <span>Edit Profile</span>

            </button>

            <div id="desktop-container">
                <?php include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/profile-container.php"; ?>
            </div>

        </div>

    </header>


    <div class="main-content-scrollable">

        <form id="profileForm" onsubmit="saveProfileData(event)" method="post">

            <div class="profile-grid-layout">

                <!-- LEFT CARD -->
                <div class="profile-side-card">

                    <div class="profile-wrapper">

                        <div class="card-picture profile">

                            <img src=""
                                alt="Student Avatar"
                                id="profileImgDisplay">

                            <div class="avatar-overlay"
                                onclick="triggerImageUpload()">

                                <i  class="fa-solid fa-camera" style="visibility: hidden;"></i>
                                <span style="visibility: hidden;">Change Photo</span>

                            </div>

                        </div>

                    </div>

                    <input type="file"
                        id="profile-image-input"
                        accept="image/*"
                        onchange="previewProfileImage(this)"
                        disabled
                        style="display:none;">

                    <button type="button"
                        class="remove-photo-btn"
                        id="removePhotoBtn"
                        onclick="resetImage()"
                        style="display:none; margin-top:18px;">

                        <i class="fa-solid fa-trash-can"></i>
                        <span>Remove Photo</span>

                    </button>

                    <h3 class="profile-teacher-name"
                        id="sideCardName"></h3>

                    <span class="profile-teacher-role">
                        Student
                    </span>

                    <div class="profile-meta-list">

                        <div class="meta-item">
                            <i class="fa-solid fa-id-card"></i>

                            <div class="meta-content">
                                <span class="meta-label">Student ID</span>
                                <span class="meta-value"
                                    id="sideCardSid"></span>
                            </div>
                        </div>

                        <div class="meta-item">
                            <i class="fa-solid fa-envelope"></i>

                            <div class="meta-content">
                                <span class="meta-label">Email</span>
                                <span class="meta-value"
                                    id="sideCardEmail"></span>
                            </div>
                        </div>

                        <div class="meta-item">
                            <i class="fa-solid fa-school"></i>

                            <div class="meta-content">
                                <span class="meta-label">Class</span>
                                <span class="meta-value"
                                    id="sideCardClass"></span>
                            </div>
                        </div>

                        <div class="meta-item">
                            <i class="fa-solid fa-users"></i>

                            <div class="meta-content">
                                <span class="meta-label">Section</span>
                                <span class="meta-value"
                                    id="sideCardSection"></span>
                            </div>
                        </div>

                        <div class="meta-item">
                            <i class="fa-solid fa-user-shield"></i>

                            <div class="meta-content">
                                <span class="meta-label">Role Category</span>
                                <span class="meta-value">Student</span>
                            </div>
                        </div>

                    </div>

                </div>


                <!-- RIGHT SIDE -->
                <div>

                    <!-- STATS -->
                    <div class="stats-summary-grid">

                        <div class="stat-badge-card">

                            <div class="stat-badge-icon">
                                <i class="fa-solid fa-school"></i>
                            </div>

                            <div class="stat-badge-details">
                                <span class="stat-badge-label">Class</span>
                                <span class="stat-badge-number"
                                    id="studentClass"></span>
                            </div>

                        </div>


                        <div class="stat-badge-card">

                            <div class="stat-badge-icon">
                                <i class="fa-solid fa-users"></i>
                            </div>

                            <div class="stat-badge-details">
                                <span class="stat-badge-label">Section</span>
                                <span class="stat-badge-number"
                                    id="studentSection"></span>
                            </div>

                        </div>


                        <div class="stat-badge-card">

                            <div class="stat-badge-icon">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>

                            <div class="stat-badge-details">
                                <span class="stat-badge-label">Attendance</span>
                                <span class="stat-badge-number"
                                    id="attendancePercentage"></span>
                            </div>

                        </div>

                    </div>


                    <!-- PERSONAL INFORMATION -->
                    <div class="inner-form-card">

                        <div class="section-header">
                            <i class="fa-solid fa-address-card"></i>
                            <h3>Personal Information</h3>
                        </div>


                        <div class="form-grid">

                            <div class="form-group">
                                <label class="form-label">Full Name</label>

                                <div class="form-control-wrapper">
                                    <input type="text"
                                        class="form-control"
                                        id="name"
                                        disabled>

                                    <i class="fa-solid fa-lock lock-icon"></i>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="form-label">Email</label>

                                <div class="form-control-wrapper">
                                    <input type="email"
                                        class="form-control"
                                        id="email"
                                        disabled>

                                    <i class="fa-solid fa-lock lock-icon"></i>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="form-label">
                                    Phone Number
                                    <span style="color:#2563eb;font-size:9px;">
                                        (Editable)
                                    </span>
                                </label>

                                <input type="text"
                                    class="form-control"
                                    id="phone"
                                    disabled>
                            </div>


                            <div class="form-group">
                                <label class="form-label">Age</label>

                                <div class="form-control-wrapper">
                                    <input type="text"
                                        class="form-control"
                                        id="age"
                                        disabled>

                                    <i class="fa-solid fa-lock lock-icon"></i>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="form-label">Gender</label>

                                <div class="form-control-wrapper">
                                    <input type="text"
                                        class="form-control"
                                        id="gender"
                                        disabled>

                                    <i class="fa-solid fa-lock lock-icon"></i>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="form-label">Status</label>

                                <div class="form-control-wrapper">
                                    <input type="text"
                                        class="form-control"
                                        id="status"
                                        disabled>

                                    <i class="fa-solid fa-lock lock-icon"></i>
                                </div>
                            </div>

                            <div class="form-group form-full">
                                <label class="form-label">
                                    Address
                                    <span style="color:#2563eb;font-size:9px;">
                                        (Editable)
                                    </span>
                                </label>

                                <input type="text"
                                    class="form-control"
                                    id="address"
                                    disabled>
                            </div>

                        </div>


                        <div class="modal-footer"
                            id="profileFormActions"
                            style="display:none;">

                            <button class="btn cancel-btn"
                                type="button"
                                onclick="cancelEditMode()">
                                Cancel
                            </button>

                            <button class="btn btn-primary"
                                type="submit">
                                Save Changes
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </form>


        <!-- Academic Overview -->
        <div class="inner-form-card">

            <div class="section-header">
                <i class="fa-solid fa-graduation-cap"></i>
                <h3>Academic Overview</h3>
            </div>

            <div class="profile-meta-list">

                <div class="meta-item">
                    <i class="fa-solid fa-school"></i>

                    <div class="meta-content">
                        <span class="meta-label">Current Class</span>
                        <span class="meta-value"
                            id="overviewClass"></span>
                    </div>
                </div>

                <div class="meta-item">
                    <i class="fa-solid fa-users"></i>

                    <div class="meta-content">
                        <span class="meta-label">Section</span>
                        <span class="meta-value"
                            id="overviewSection"></span>
                    </div>
                </div>

                <div class="meta-item">
                    <i class="fa-solid fa-user-check"></i>

                    <div class="meta-content">
                        <span class="meta-label">Status</span>
                        <span class="meta-value"
                            id="overviewStatus"></span>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/confirmation-dialogue-box.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/school_management_system/includes/floating_filter.php";
    ?>

    <!-- TOAST CONTAINER -->
    <div class="toast-container" id="toastContainer"></div>

</main>

</div>

<!-- CUSTOM JS -->
<script src="/school_management_system/assets/js/script.js"></script>
<script src="/school_management_system/assets/js/student-profile.js"></script>

</body>

</html>
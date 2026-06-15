<?php
// ROLE BASED AUTHENTICATION
include $_SERVER['DOCUMENT_ROOT'] . "/student_management_system/includes/teacher_auth.php";

// include sidebar
include $_SERVER['DOCUMENT_ROOT'] . "/student_management_system/includes/teacher_sidebar.php";

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
                <h2>Student Management Center</h2>
                <p>Manage and monitor students based on your assigned classes and subjects.</p>
            </div>

        </div>
        <div class="topbar-btns">

            <?php

            $userName = $_SESSION['user_name'];
            $userEmail = $_SESSION['user_email'];
            $userRole = $_SESSION['role'];

            $profileImage = !empty($_SESSION['user_image'])
                ? "/student_management_system/" . $_SESSION['user_image']
                : "/student_management_system/uploads/profile-img.jpg";


            ?>

            <div class="btn-primary" style="padding: 8px 16px; border-radius: 10px; font-size: 12.5px; font-weight: 700;">
                <?= $userRole ?>
            </div>

            <!-- USER PROFILE DROPDOWN CONTAINER -->
            <div class="user-profile-container">
                <button class="profile-trigger-btn" id="profileTrigger" aria-label="Open user menu">
                    <img src="<?= $profileImage ?>" alt="User Profile" class="user-avatar">
                </button>

                <div class="profile-dropdown-menu" id="profileDropdown">
                    <div class="dropdown-header">
                        <img src="<?= $profileImage ?>" alt="User Profile" class="dropdown-avatar">
                        <div class="user-info">
                            <h4><?= $userName ?></h4>
                            <p><?= $userEmail ?></p>
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

        <!-- Profile Base Grid split (Left Sidebar Summary & Right editable tabs) -->
        <form id="profileForm" onsubmit="saveProfileData(event)">
            <div class="profile-grid-layout">

                <!-- COLUMN 1: Profile Header Summary Card -->
                <div class="profile-side-card">

                    <!-- Profile picture wrapper (Only change-photo visible on edit-active) -->
                    <div class="profile-wrapper">
                        <div class="card-picture">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&auto=format&fit=crop&q=80" alt="Teacher Avatar" id="profileImgDisplay">
                            <div class="avatar-overlay" onclick="triggerImageUpload()">
                                <i class="fa-solid fa-camera"></i>
                                <span>Change Photo</span>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden File input -->
                    <input type="file" id="profile-image-input" accept="image/*" onchange="previewProfileImage(this)" disabled style="display: none;">

                    <h3 class="profile-teacher-name" id="sideCardName">Muhammad Ali</h3>
                    <span class="profile-teacher-role">English Teacher</span>

                    <!-- Meta info specifications (locked/read-only parameters) -->
                    <div class="profile-meta-list">
                        <div class="meta-item">
                            <i class="fa-solid fa-id-badge"></i>
                            <div class="meta-content">
                                <span class="meta-label">Employee ID</span>
                                <span class="meta-value">EMP-00125</span>
                            </div>
                        </div>

                        <div class="meta-item">
                            <i class="fa-solid fa-envelope"></i>
                            <div class="meta-content">
                                <span class="meta-label">Official Email</span>
                                <span class="meta-value" id="sideCardEmail">ali@gmail.com</span>
                            </div>
                        </div>

                        <div class="meta-item">
                            <i class="fa-solid fa-calendar-days"></i>
                            <div class="meta-content">
                                <span class="meta-label">Joining Date</span>
                                <span class="meta-value">12 Jan 2024</span>
                            </div>
                        </div>

                        <div class="meta-item">
                            <i class="fa-solid fa-user-shield"></i>
                            <div class="meta-content">
                                <span class="meta-label">Role Category</span>
                                <span class="meta-value">Teacher / Academic</span>
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
                                <span class="stat-badge-number">3</span>
                            </div>
                        </div>

                        <div class="stat-badge-card">
                            <div class="stat-badge-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                                <i class="fa-solid fa-book-open"></i>
                            </div>
                            <div class="stat-badge-details">
                                <span class="stat-badge-label">Assigned Subjects</span>
                                <span class="stat-badge-number">2</span>
                            </div>
                        </div>

                        <div class="stat-badge-card">
                            <div class="stat-badge-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                            <div class="stat-badge-details">
                                <span class="stat-badge-label">Total Students</span>
                                <span class="stat-badge-number">180</span>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information inner card (Edit validation controlled) -->
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
                                    <input type="text" class="form-control" id="teacherName" value="Muhammad Ali" disabled>
                                    <i class="fa-solid fa-lock lock-icon" title="Can only be edited by Admin"></i>
                                </div>
                            </div>

                            <!-- Email (Locked) -->
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <div class="form-control-wrapper">
                                    <input type="email" class="form-control" id="teacherEmail" value="ali@gmail.com" disabled>
                                    <i class="fa-solid fa-lock lock-icon" title="Can only be edited by Admin"></i>
                                </div>
                            </div>

                            <!-- Phone (EDITABLE) -->
                            <div class="form-group">
                                <label class="form-label">Phone Number <span style="color: #2563eb; font-size:9px;">(Editable)</span></label>
                                <input type="tel" class="form-control" id="teacherPhone" value="+92 300 9876543" required disabled>
                            </div>

                            <!-- Gender (Locked) -->
                            <div class="form-group">
                                <label class="form-label">Gender</label>
                                <div class="form-control-wrapper">
                                    <input type="text" class="form-control" id="teacherGender" value="Male" disabled>
                                    <i class="fa-solid fa-lock lock-icon" title="Can only be edited by Admin"></i>
                                </div>
                            </div>

                            <!-- Date Of Birth (Locked) -->
                            <div class="form-group">
                                <label class="form-label">Date Of Birth</label>
                                <div class="form-control-wrapper">
                                    <input type="date" class="form-control" id="teacherDob" value="1992-11-20" disabled>
                                    <i class="fa-solid fa-lock lock-icon" title="Can only be edited by Admin"></i>
                                </div>
                            </div>

                            <!-- Account Status (Locked Info badge) -->
                            <div class="form-group">
                                <label class="form-label">Account Status</label>
                                <div class="form-control-wrapper">
                                    <input type="text" class="form-control" value="ACTIVE" style="color: #10b981; font-weight:800;" disabled>
                                    <i class="fa-solid fa-shield-halved lock-icon"></i>
                                </div>
                            </div>

                            <!-- Residential Address (EDITABLE) -->
                            <div class="form-group form-full">
                                <label class="form-label">Residential Address <span style="color: #2563eb; font-size:9px;">(Editable)</span></label>
                                <input type="text" class="form-control" id="teacherAddress" value="Apartment 4B, Gulshan-e-Iqbal, Karachi" required disabled>
                            </div>
                        </div>

                        <!-- Form Actions (Appears on edit state) -->
                        <div class="modal-footer" id="profileFormActions" style="display: none; padding-top: 16px; margin-top: 16px;">
                            <button class="btn cancel-btn" type="button" onclick="cancelEditMode()">Cancel</button>
                            <button class="btn btn-primary" type="submit">Save Changes</button>
                        </div>
                    </div>

                    <!-- Assigned Classes & Subjects Card (Read-Only list from Admin records) -->
                    <div class="inner-form-card">
                        <div class="section-header">
                            <i class="fa-solid fa-book-bookmark"></i>
                            <h3>Assigned Classes & Subjects</h3>
                        </div>

                        <div class="assignments-list">
                            <div class="assignment-row">
                                <div class="assignment-info">
                                    <div class="class-icon"><i class="fa-solid fa-landmark"></i></div>
                                    <div>
                                        <div class="class-title">Class 7-A</div>
                                        <div class="class-subject">Primary Subject: English Literature</div>
                                    </div>
                                </div>
                                <span class="badge-tag class-teacher">Class Teacher</span>
                            </div>

                            <div class="assignment-row">
                                <div class="assignment-info">
                                    <div class="class-icon" style="background: var(--left-panel-gradient);"><i class="fa-solid fa-book"></i></div>
                                    <div>
                                        <div class="class-title">Class 8-B</div>
                                        <div class="class-subject">English Language & Grammar</div>
                                    </div>
                                </div>
                                <span class="badge-tag subject-teacher">English Teacher</span>
                            </div>

                            <div class="assignment-row">
                                <div class="assignment-info">
                                    <div class="class-icon" style="background: var(--left-panel-gradient);"><i class="fa-solid fa-book"></i></div>
                                    <div>
                                        <div class="class-title">Class 9-A</div>
                                        <div class="class-subject">Advanced Composition & Literature</div>
                                    </div>
                                </div>
                                <span class="badge-tag subject-teacher">English Teacher</span>
                            </div>
                        </div>
                    </div>

                    <!-- Account Security Card -->
                    <div class="inner-form-card">
                        <div class="section-header">
                            <i class="fa-solid fa-shield-halved"></i>
                            <h3>Account Security</h3>
                        </div>

                        <div class="security-action-box">
                            <div class="security-info">
                                <span class="security-title">Account Password</span>
                                <span class="security-desc">Manage or change your authentication password. Last changed: 2 months ago</span>
                            </div>
                            <button type="button" class="btn btn-secondary" onclick="openPasswordModal()">
                                <i class="fa-solid fa-key"></i>
                                <span>Change Password</span>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </form>

    </div>
</main>
</div>

<!-- CHANGE PASSWORD POPUP MODAL (Clean styling structure) -->
<div class="modal-overlay" id="passwordModal">
    <div class="modal-container">
        <div class="modal-padding">
            <div class="modal-header-container">
                <h3>Change Password</h3>
                <button class="close-btn" onclick="closePasswordModal()"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <form id="changePasswordForm" onsubmit="handlePasswordUpdate(event)">
                <div style="display: flex; flex-direction: column; gap: 14px;">

                    <div class="form-group">
                        <label class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="currPassword" required placeholder="••••••••">
                    </div>

                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" required placeholder="Enter new password">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmNewPassword" required placeholder="Verify new password">
                    </div>

                </div>

                <div class="modal-footer" style="margin-top: 24px; padding-top: 18px;">
                    <button type="button" class="btn cancel-btn" onclick="closePasswordModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>

        </div>


        <?php

        // confirmation dialogue box
        include $_SERVER['DOCUMENT_ROOT'] . "/student_management_system/includes/confirmation-dialogue-box.php";

        // include floating filter for small screen
        include $_SERVER['DOCUMENT_ROOT'] . "/student_management_system/includes/floating_filter.php";

        ?>

        <!-- TOAST NOTIFICATIONS CONTAINER -->
        <div class="toast-container" id="toastContainer"></div>

        </main>
    </div>

    <!-- // include js -->
    <script src="/student_management_system/assets/js/script.js"></script>
    <script src="/student_management_system/assets/js/teacher-students.js"></script>
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
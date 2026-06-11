<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap + Icons -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- custom css -->
    <link href="assets/css/style.css" rel="stylesheet">


</head>

<body>

    <!-- Ambient Glow Blobs Background -->
    <div class="glowing-orb orb-left"></div>
    <div class="glowing-orb orb-right"></div>

    <!-- MAIN DASHBOARD CONTAINER -->
    <div class="login-wrapper">

        <div class="login-container">

            <!-- LEFT SIDE -->
            <section class="login-left">
                <!-- Semi-invisible light reflections -->
                <div class="glowing-orb orb-1" style="background: rgba(255,255,255,0.1); width:200px; height:200px;"></div>
                <div class="glowing-orb orb-2" style="background: rgba(255,255,255,0.06); width:200px; height:200px;"></div>

                <!-- Brand Logo -->
                <div class="left-logo-header">
                    <div class="left-logo-icon">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h1 class="left-logo-title">SMS Premium</h1>
                    </div>
                </div>

                <!-- Welcome Text -->
                <div class="left-welcome-text">
                    <h2>Welcome to the Student Management System!</h2>
                    <p>Manage student records, classes, attendance, and fees all in one powerful platform.</p>
                </div>

                <!-- ARTISTIC ABSTRACT CANVAS (Circles, Squares, Lines, Blobs in low opacity) -->
                <div class="artistic-canvas">
                    <!-- Blobs -->
                    <div class="art-shape art-blob-1"></div>
                    <div class="art-shape art-blob-2"></div>

                    <!-- Dot Grid Grid -->
                    <div class="art-shape art-grid-dots"></div>

                    <!-- Circles -->
                    <div class="art-shape art-circle-solid"></div>
                    <div class="art-shape art-circle-outline"></div>

                    <!-- Squares -->
                    <div class="art-shape art-square-1"></div>
                    <div class="art-shape art-square-2"></div>

                    <!-- Lines -->
                    <div class="art-shape art-line-1"></div>
                    <div class="art-shape art-line-2"></div>
                </div>

                <!-- Footer info inside Left Split -->
                <div class="left-footer">
                    <p>© 2026 Premium SMS. All Rights Reserved. Pro V3.5</p>
                </div>
            </section>

            <!-- RIGHT_SIDE -->
            <section class="login-right">

                <!-- Dark / Light Mode Switcher -->
                <div class="theme-toggle-container">
                    <button class="btn-icon" id="themeToggleBtn" title="Theme Badlein">
                        <i class="fa-solid fa-moon"></i>
                    </button>
                </div>

                <!-- Form Wrapper -->
                <div class="right-form-container">
                    <div class="right-title">
                        <h3>Please Sign In</h3>
                        <p>Enter your credentials to securely access your account.</p>
                    </div>

                    <form id="loginForm" method="post" action="login.php">

                        <!-- USERNAME / EMAIL FIELD -->
                        <div class="form-group" style="margin-bottom: 18px;">
                            <label class="form-label" for="username">Username or Email Address *</label>
                            <div class="input-icon-wrapper">
                                <i class="fa-solid fa-envelope"></i>
                                <input name="email" style="width: 100%; height: 46px; padding: 0 16px 0 46px;" type="text" id="username" required="" placeholder="admin@domain.com" class="form-control" autocomplete="username">
                            </div>
                        </div>

                        <!-- PASSWORD FIELD -->
                        <div class="form-group" style="margin-bottom: 18px;">
                            <label class="form-label" for="password">Password *</label>
                            <div class="input-icon-wrapper">
                                <i class="fa-solid fa-lock"></i>
                                <input name="password" style="width: 100%; height: 46px; padding: 0 16px 0 46px;" type="password" id="password" required="" placeholder="••••••••" class="form-control" autocomplete="current-password">
                            </div>
                        </div>

                        <!-- ROLE SELECTOR FIELD -->
                        <!-- <div class="form-group">
                            <label class="form-label" for="userRole">Role (Bhoomika) *</label>
                            <div class="input-icon-wrapper">
                                <i class="fa-solid fa-user-shield"></i>
                                <select id="userRole" required="" class="form-control select-custom">
                                    <option value="Prabandhak">Prabandhak (Admin)</option>
                                    <option value="Shikshak">Shikshak (Teacher)</option>
                                    <option value="Chhatra">Chhatra (Student)</option>
                                </select>
                                <i class="fa-solid fa-chevron-down select-arrow"></i>
                            </div>
                        </div> -->

                        <!-- Remember Me / Forgot Password option row -->
                        <div class="login-options">
                            <label class="remember-me">
                                <input type="checkbox" id="rememberMe">
                                <span>Remember Me</span>
                            </label>
                            <a href="#" class="forgot-pass">Forgot Password?</a>
                        </div>

                        <!-- LOGIN SUBMIT BUTTON -->
                        <button type="submit" class="btn-submit">
                            <span>Sign In</span>
                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        </button>
                    </form>
                </div>

                <!-- Footer Text -->
                <!-- <div class="right-footer">
                    <p>Naye upbhokta hain? <a href="#" onclick="showToast('Sahaayata', 'Naya account banane ke liye super admin se sampark karein.', 'info')">Registration Karein</a></p>
                </div> -->
            </section>

        </div>

    </div>

</body>

</html>
 <?php

    $userName = $_SESSION['user_name'];
    $userEmail = $_SESSION['user_email'];
    $userRole = $_SESSION['role'];

    $profileImage = !empty($_SESSION['user_image'])
        ? "/school_management_system/" . $_SESSION['user_image']
        : "/school_management_system/uploads/profile-img.jpg";

    ?>
 
 <div style="display: flex; gap:5px;">

     <button class="btn-primary" style="border: none; padding: 8px 16px; border-radius: 10px; font-size: 12.5px; font-weight: 700;">
         <?= $userRole ?>
     </button>

     <!-- USER PROFILE DROPDOWN CONTAINER -->
     <div class="user-profile-container mobile ">
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
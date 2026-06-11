 <?php
    // include db
    include $_SERVER['DOCUMENT_ROOT'] . "/student_management_system/config/connection.php";
    ?>

 <!-- FLOATING FILTER BOTTOM SHEET (MOBILE ONLY) -->
 <div class="bottom-sheet-overlay" id="bottomSheetOverlay">

     <div class="bottom-sheet">

         <div class="bottom-sheet-header">
             <h3>Filter Students</h3>
             <button onclick="resetFilter()" class="btn-action close-btn" id="closeBottomSheet"><i class="fa-solid fa-xmark"></i></button>
         </div>

         <div class="bottom-sheet-body">
             <div class="form-group">
                 <span class="form-label">Class</span>

                 <div class="dropdowns" id="">

                     <select name="" id="mobileClassFilter" class="select-custom classFilter">
                         <option value="All">All Classes</option>
                         <?php include "classDropdown.php" ?>
                     </select>
                     <i class="fa-solid fa-chevron-down"></i>

                 </div>

             </div>
             <div class="form-group">
                 <span class="form-label">Section</span>
                 <!-- SECTION DROPDOWN -->
                 <div class="dropdowns">
                     <select name="" id="mobileSectionFilter" class="select-custom sectionDropdown" required>
                         <option disabled selected value="All">Select Class First</option>
                         <?php include "sectionDropdown.php" ?>
                     </select>
                     <i class="fa-solid fa-chevron-down"></i>
                 </div>

             </div>
             <div class="form-group">
                 <span class="form-label">Gender</span>
                 <div class="dropdowns">
                     <select id="mobileGenderFilter" class="select-custom" style="width:100%;">
                         <option value="All">All Genders</option>
                         <option value="Male">Male</option>
                         <option value="Female">Female</option>
                     </select>
                 </div>
             </div>

             <div style="display:flex; gap:12px; margin-top:8px;">
                 <button class="btn btn-primary applyMobileFiltersBtn" id="" style="flex:1;">Apply Filters</button>
                 <button onclick="resetFilter()" class="btn btn-icon" id="clearMobileFiltersBtn" style="width:44px; font-size: 14px;"><i class="fa-solid fa-trash-can"></i></button>
             </div>

         </div>
     </div>
 </div>
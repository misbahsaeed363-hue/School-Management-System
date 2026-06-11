<!-- Add Student Popup -->
<div id="studentModal" class="modal-overlay">

    <!-- FORM -->
    <form action="addphp.php" method="post" enctype="multipart/form-data" id="studentForm">

        <div class="modal-container student">

            <!-- LEFT MODAL -->
            <div class="left-modal">

                <div class="profile-wrapper">

                    <div class="card-picture">

                        <i class="fa-solid fa-user"></i>

                        <div class="avatar-overlay">
                            <i class="fa-solid fa-camera"></i>
                            <span>Upload Photo</span>
                        </div>

                    </div>

                    <!-- Image input  -->
                    <input type="file" name="image" id="image-input">

                    <!-- Action instructions -->
                    <p class="left-modal-hint">Click on the profile circle to upload a photo.</p>

                    <!-- Minimalist remove icon -->
                    <button type="button" class="remove-photo-btn" id="clearImgBtn" onclick="resetImage()" style="display: none;">
                        <i class="fa-solid fa-trash-can"></i>
                        <span>Remove Photo</span>
                    </button>

                </div>

            </div>

            <!-- RIGHT MODAL -->
            <div class="right-modal">

                <div class="modal-header">
                    <h3>Add new Student</h3>
                    <button onclick="closeModal(); resetImage();" class="btn-action close-btn" type="button"><i class="fa-solid fa-xmark"></i></button>
                </div>

                <div class="form-grid">

                    <input type="hidden" name="sid" id="id-input">
                    <input type="hidden" name="old_image" id="old-image">

                    <div class="form-group">
                        <label for="" class="form-label">Student's Name</label>
                        <input id="name-input" type="text" placeholder="Enter your Name" class="form-control" name="sname" required>
                    </div>

                    <div class="form-group">
                        <label for="" class="form-label">Age</label>
                        <input id="age-input" type="number" placeholder="Enter your Name" class="form-control" name="sage" required>
                    </div>

                    <div class="form-group">
                        <label for="" class="form-label">Phone Number</label>
                        <input id="phone-input" type="number" placeholder="Enter your Name" class="form-control" name="sphone" required>
                    </div>

                    <div class="form-group">
                        <label for="" class="form-label">Class</label>
                        <select name="sclass" class="form-control selectClass">
                            <option value="All" selected disabled>All Classes</option>
                            <?php include "classDropdown.php" ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="" class="form-label">Address</label>
                        <input id="address-input" type="text" placeholder="Enter your Name" class="form-control" name="saddress" required>
                    </div>

                    <div class="form-group">
                        <label for="" class="form-label">Gender</label>
                        <select name="sgender" class="form-control" id="genderDropdown">
                            <option value="Male" selected>Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="" class="form-label">Email</label>
                        <input id="email-input" type="email" placeholder="Enter your Name" class="form-control" name="semail">
                    </div>

                    <div class="form-group">
                        <label for="" class="form-label">Status</label>
                        <select name="sstatus" class="form-control" id="statusDropdown">
                            <option value="Active" selected>Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="" class="form-label">Section</label>
                        <select name="ssection" class="form-control sectionDropdown" id="studentSection" required>
                            <option disabled selected value="select-class" class="section-option">Select Class First</option>
                            <?php include "sectionDropdown.php" ?>
                        </select>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button class="btn cancel-btn" type="button" onclick="closeModal(); resetImage();">Cancel</button>
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </div>

        </div>
    </form>
</div>
<!-- Add TEACHER Popup -->
<div id="teacherModal" class="modal-overlay">

    <!-- FORM -->
    <form action="add_teacher.php" method="post" enctype="multipart/form-data" id="teacherForm">

        <div class="modal-container student">

            <div class="modal-header mobile">
                <h3 class="modal-heading">Add new Teacher</h3>
                <button onclick="closeModal(); resetImage();" class="btn-action close-btn" type="button"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <!-- LEFT MODAL -->
            <div class="left-modal">

                <div class="profile-wrapper">

                    <div class="card-picture" id="teacher-card-picture">

                        <i class="fa-solid fa-user"></i>

                        <div class="avatar-overlay">
                            <i class="fa-solid fa-camera"></i>
                            <span>Upload Photo</span>
                        </div>

                    </div>

                    <!-- Image input  -->
                    <input type="file" name="image" id="image-input" class="teacher-image-input">

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

                <div class="modal-header desktop">
                    <h3 class="modal-heading">Add new Teacher</h3>
                    <button onclick="closeModal(); resetImage();" class="btn-action close-btn" type="button"><i class="fa-solid fa-xmark"></i></button>
                </div>

                <div class="modal-scrollable-body double">

                    <div class="form-grid">

                        <input type="hidden" name="id" id="id-input">
                        <input type="hidden" name="old_image" id="old-image">

                        <div class="form-group">
                            <label for="" class="form-label">Name</label>
                            <input id="name-input" type="text" placeholder="Enter Name" class="form-control" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="" class="form-label">Phone Number</label>
                            <input id="phone-input" type="tel" placeholder="Enter your Name" class="form-control" name="phone" required>
                        </div>

                        <div class="form-group">
                            <label for="" class="form-label">Date Of birth</label>
                            <input id="dob-input" type="date" placeholder="Enter your Name" class="form-control" name="date_of_birth" required>
                        </div>

                        <div class="form-group">
                            <label for="" class="form-label">Qualification</label>
                            <input id="qualification-input" type="text" placeholder="Enter your Name" class="form-control" name="qualification" required>
                        </div>

                        <div class="form-group">
                            <label for="" class="form-label">Experience Year</label>
                            <input id="experience-input" type="number" placeholder="Enter your Name" class="form-control" name="experience_years" required>
                        </div>

                        <div class="form-group">
                            <label for="" class="form-label">Salary</label>
                            <input id="salary-input" type="number" placeholder="Enter your Name" class="form-control" name="salary" required>
                        </div>

                        <div class="form-group">
                            <label for="" class="form-label">Marital Status</label>
                            <select name="marital_status" class="form-control" id="maritalStatusDropdown">
                                <option value="Married" selected>Married</option>
                                <option value="Unmarried">Unmarried</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="" class="form-label">Gender</label>
                            <select name="gender" class="form-control" id="genderDropdown">
                                <option value="Male" selected>Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="" class="form-label">Email</label>
                            <input id="email-input" type="email" placeholder="Enter your Name" class="form-control" name="email">
                        </div>

                        <div class="form-group">
                            <label for="" class="form-label">Status</label>
                            <select name="status" class="form-control" id="statusDropdown">
                                <option value="Active" selected>Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="" class="form-label">Residental Address</label>
                            <input id="address-input" type="text" placeholder="Enter your Name" class="form-control" name="address" required>
                        </div>

                        <div class="form-group">
                            <label for="joining_date" class="form-label">Joining Date</label>
                            <input type="date" id="joining_date-input" name="joining_date" class="form-control" required>
                        </div>

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
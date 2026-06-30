<div id="viewStudentModal" class="modal-overlay">
    <div class="modal-container student glass-card" style="max-width: 650px;">

        <div style="padding: 24px; width: 100%;">
            <div class="view-modal-header">
                <h3 class="modal-heading">Student Profile Details</h3>
                <button onclick="closeModal();" class="btn-action close-btn" type="button">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="view-modal-body">

                <div class="view-profile-sidebar">
                    <div class="profile-wrapper" >
                        <div id="view-student-img-container" class="card-picture">
                        </div>
                    </div>
                    <h4 id="view-student-name" class="view-student-title"></h4>
                    <span id="view-student-status" class="view-status-badge"></span>
                </div>

                <div class="view-info-pane">
                    <div class="view-data-grid">

                        <div class="form-group view-grid-full">
                            <span class="view-meta-label">Email Address</span>
                            <div id="view-student-email" class="view-meta-value"></div>
                        </div>

                        <div class="form-group">
                            <span class="view-meta-label">Phone / Contact</span>
                            <div id="view-student-phone" class="view-meta-value"></div>
                        </div>

                        <div class="form-group">
                            <span class="view-meta-label">Age</span>
                            <div id="view-student-age" class="view-meta-value"></div>
                        </div>

                        <div class="form-group">
                            <span class="view-meta-label">Class</span>
                            <div id="view-student-class" class="view-meta-value"></div>
                        </div>

                        <div class="form-group">
                            <span class="view-meta-label">Section</span>
                            <div id="view-student-section" class="view-meta-value"></div>
                        </div>

                        <div class="form-group">
                            <span class="view-meta-label">Gender</span>
                            <div id="view-student-gender" class="view-meta-value"></div>
                        </div>

                        <div class="form-group view-grid-full">
                            <span class="view-meta-label">Address</span>
                            <div id="view-student-address" class="view-meta-value"></div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="view-modal-footer">
                <button class="btn cancel-btn" type="button" onclick="closeModal();">Close</button>
            </div>
        </div>

    </div>
</div>
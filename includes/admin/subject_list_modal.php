<?php

?>

<!-- SUBJECT LIST MODAL -->
<div class="modal-overlay" id="subject-list-Modal">

    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

        <!-- MODAL CONTAINER -->
        <div class="modal-container single">

            <!-- MODAL HEADER -->
            <div class="modal-header single">

                <div style="display: flex; flex-direction: column;">
                    <h3 id="subject-list-title" style="font-size: 18px; font-weight: 800;"></h3>
                    <p id="subject-list-para" style=" font-size: 12px; color: var(--text-muted); font-weight: 500;">Manage Subjects and Assigned Teachers list</p>
                </div>

                <button onclick="closeModal()" class="btn-action close-btn" type="button"><i class="fa-solid fa-xmark"></i></button>

            </div>


            <!-- MODAL BODY -->
            <div class="modal-body single">

                <div class="form-grid single">

                    <div class="modal-scrollable-body single">

                        <div class="modal-subject-teacher-list">

                            <!-- MODAL SECTION LIST ADDED THROUGH JS -->

                        </div>

                    </div>

                </div>

                <!-- Add New Subject Option directly in modal -->
                <div style="border-top: 1px solid var(--row-border); margin-top: 16px; padding-top: 16px;">

                    <h4 style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 800; color: var(--text-muted); margin-bottom: 10px;">ADD NEW SUBJECT</h4>

                    <div style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 7px; align-items: center;">
                        <input type="text" id="newSubjectNameInput" class="form-control" placeholder="Subject Name (e.g. Science)" style="height: 35px; padding: 0 10px; font-size: 12px;">

                        <select id="newSubjectTeacherInput" class="form-control" style="height: 35px; padding: 0 10px; font-size: 12px;">
                            <?php include "teacherDropdown.php" ?>
                        </select>

                        <button class="btn btn-primary" onclick="addNewSubjectToSection()">
                            <i class="fa-solid fa-plus"></i> Add
                        </button>
                    </div>

                </div>

            </div>


        </div>

    </form>

</div>

<!-- ADD SECTION MODAL -->
<div class="modal-overlay" id="addSection">

    <form action="addSectionphp.php" method="post" id="addsectionModal">

        <!-- MODAL CONTAINER -->
        <div class="modal-container single">

            <!-- MODAL HEADER -->
            <div class="modal-header single">

                <h3>Add new Section</h3>
                <button onclick="closeModal()" class="btn-action close-btn" type="button"><i class="fa-solid fa-xmark"></i></button>

            </div>

            <!-- MODAL BODY -->
            <div class="modal-body single">

                <div class="form-grid single section">

                    <div class="form-group">
                        <label for="" class="form-label">Select Class</label>
                        <select name="sclass" class="form-control" required>
                            <?php include "classDropdown.php" ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="" class="form-label">Section Name</label>
                        <input type="text" placeholder="e.g. Section C" class="form-control" name="sec-name" required>
                    </div>

                    <div class="form-group">
                        <label for="" class="form-label">Select Teacher</label>
                        <select name="sec-teacher" class="form-control" required>
                            <?php include "teacherDropdown.php" ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="" class="form-label">Capacity</label>
                        <input type="text" placeholder="Enter Section Capacity" class="form-control" name="sec-capacity" required>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button class="btn cancel-btn" type="button" onclick="closeModal()">Cancel</button>
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>

            </div>

        </div>

    </form>

</div>
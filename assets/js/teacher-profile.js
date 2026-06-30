document.addEventListener("DOMContentLoaded", () => {
    loadTeacherProfile();
});

function loadTeacherProfile() {

    fetch("/school_management_system/teacher/APIs/get_teacher_profile.php")
        .then(response => response.json())
        .then(data => {

            // =========================
            // Teacher Information
            // =========================

            if (data.teacher) {

                document.getElementById("email").value =
                    data.teacher.email ?? "";

                document.getElementById("gender").value =
                    data.teacher.gender ?? "";

                document.getElementById("name").value =
                    data.teacher.name ?? "";

                document.getElementById("phone").value =
                    data.teacher.phone ?? "";

                document.getElementById("dob").value =
                    data.teacher.date_of_birth ?? "";

                document.getElementById("experience_years").value =
                    data.teacher.experience_years ?? "";

                document.getElementById("salary").value =
                    data.teacher.salary ?? "";

                document.getElementById("address").value =
                    data.teacher.address ?? "";

                document.getElementById("marital_status").value =
                    data.teacher.marital_status ?? "";

                document.getElementById("status").value =
                    data.teacher.status ?? "";

                // Sidebar

                const sideName =
                    document.getElementById("sideCardName");

                if (sideName) {
                    sideName.textContent =
                        data.teacher.name ?? "";
                }

                const sideId =
                    document.getElementById("sideCardTid");

                if (sideId) {
                    sideId.textContent =
                        data.teacher.tid ?? "";
                }

                const sideEmail =
                    document.getElementById("sideCardEmail");

                if (sideEmail) {
                    sideEmail.textContent =
                        data.teacher.email ?? "";
                }

                const sideQualification = document.getElementById("sideCardQualification");

                if (sideQualification) {
                    sideQualification.textContent = data.teacher.qualification ?? "";
                }

                const joiningDate = document.getElementById("sideCardDate");

                if (joiningDate) {
                    joiningDate.textContent = data.teacher.joining_date ?? "";
                }


                // Profile Image

                if (
                    data.teacher.images &&
                    document.getElementById("profileImgDisplay")
                ) {
                    document.getElementById(
                        "profileImgDisplay"
                    ).src =
                        "/school_management_system/" +
                        data.teacher.images;
                }
            }

            // =========================
            // Statistics Cards
            // =========================

            const assignedClasses =
                document.getElementById("assignedClasses");

            if (assignedClasses) {
                assignedClasses.textContent =
                    data.assigned_classes ?? 0;
            }

            const assignedSubjects =
                document.getElementById("assignedSubjects");

            if (assignedSubjects) {
                assignedSubjects.textContent =
                    data.assigned_subjects ?? 0;
            }

            const totalStudents =
                document.getElementById("totalStudents");

            if (totalStudents) {
                totalStudents.textContent =
                    data.total_students ?? 0;
            }

            // =========================
            // Assigned Classes & Subjects
            // =========================

            const assignmentsContainer =
                document.getElementById("assignmentsList");

            if (
                assignmentsContainer &&
                data.assignments
            ) {

                assignmentsContainer.innerHTML = "";

                data.assignments.forEach(item => {

                    assignmentsContainer.innerHTML += `

                    <div class="assignment-row">

                        <div class="assignment-info">

                            <div class="class-icon">
                                <i class="fa-solid fa-book"></i>
                            </div>

                            <div>

                                <div class="class-title">
                                    ${item.class_name} - ${item.section_name}
                                </div>

                                <div class="class-subject">
                                    ${item.subject_name}
                                </div>

                            </div>

                        </div>

                        <span class="badge-tag subject-teacher">
                            ${item.subject_code}
                        </span>

                    </div>

                    `;
                });
            }
        })

}
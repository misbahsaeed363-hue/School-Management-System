// for apply filter and pagination
function loadTeachers(page = 1) {

    let search = document.querySelector("#searchInput").value;
    let classFilter = document.querySelector("#desktopClassFilter")?.value || "All";
    let sectionFilter = document.querySelector("#desktopSectionFilter")?.value || "All";
    let genderFilter = document.querySelector("#desktopGenderFilter")?.value || "All";

    fetch(`/student_management_system/admin/load_teachers.php/?page=${page}&search=${search}&class=${classFilter}&section=${sectionFilter}&gender=${genderFilter}`)
        .then(res => res.json())
        .then(data => {

            renderTeacherTable(data.data);

            renderCard(data.data);

            document.querySelector(".pagination-info").innerHTML = `
            Showing Page ${data.currentPage} of ${data.totalPages} (${data.totalRecords} Teachers)
            `;

            renderTeacherPagination(
                data.totalPages,
                data.currentPage
            );
        })
}

function renderTeacherTable(data) {

    let teacherTable = `
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Contact Details</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Class</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    `;

    if (data.length === 0) {
        teacherTable += `
            <tr>
                <td colspan="5" style="text-align:center;">
                    No records found
                </td>
            </tr>
        `;
    } else {

        data.forEach(teacher => {
            teacherTable += `
                <tr class="teacher-table-row">
                    <td class="teacher-id-col">${teacher.tid}</td>
                    <td><img class="student-img" src="/student_management_system/${teacher.images}"></td>
                    <td>${teacher.name}</td>
                    <td>
                    <div class="contact-cell">
                                            <h5>${teacher.email}</h5>
                                            <span>${teacher.phone}</span>
                                        </div>
                    </td>
                    <td>${teacher.gender}</td>
                    <td>${teacher.address}</td>
                    <td>${teacher.class_id}
                    ${teacher.section_name}
                    </td>
                    <td> 
                    <span class="status ${teacher.status === "Active" ? "active" : ""}">${teacher.status}</span></td>
                    <td>
                    <div class="btns-action">
                        <button class="btn-action edit teacher" title="Edit"><i class="fa-solid fa-pen"></i></button>
                        <a class="btn-action delete teacher" href="deletephp.php?delete=${teacher.tid}" title="Delete"><i class="fa-solid fa-trash"></i></a>
                    </div>
                    </td>
                </tr>
            `;
        });
    }

    teacherTable += `
            </tbody>
        </table>
    `;

    document.querySelector("#teacherTable").innerHTML = teacherTable;
}

function renderCard(data) {

    let cards = "";

    if (data.length === 0) {
        cards = `
        <div class="student-card">
                No records found
        </div>
        `
    } else {
        data.forEach(teacher => {

            cards += `
                <div class="student-mobile-card">

                <div class="card-top-bar">
                    <span class="card-student-id">${teacher.sid}</span>
                    <div class="card-top-actions">
                        <span class="status active" style="font-size:10px; padding:4px 10px;">${teacher.status}</span>

                        <button class="card-options-trigger">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <div class="card-options-dropdown" id="dropdown">
                    <button class="dropdown-opt">
                        <i class="fa-solid fa-pen" style="color:#2563eb;"></i> Edit Student
                    </button>
                    <button class="dropdown-opt opt-delete">
                        <i class="fa-solid fa-trash"></i> Delete
                    </button>
                </div>
                    </div>
                </div>

                <div class="card-header-flex">
                    <img src="${teacher.images}" class="student-img active-border">
                    <div class="card-header-info">
                        <h4>${teacher.name}</h4>
                        <p>Class ${teacher.class_id} •
                            Sec ${teacher.section_name} • 
                            ${teacher.gender}
                        </p>
                    </div>
                </div>
                <div class="card-accordion-toggle">
                    <span class="toggle-text">View Details</span> <i class="fa-solid fa-chevron-down"></i>
                </div>
                <div class="card-accordion-content">
                        <div class="card-body-details">
                            <div class="detail-row">
                                <span class="detail-label">Roll No</span>
                                <span class="detail-value">Roll-01</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Email</span>
                                <span class="detail-value">${teacher.email}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Phone</span>
                                <span class="detail-value">${teacher.phone}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Address</span>
                                <span class="detail-value">${teacher.gender}</span>
                            </div>
                        </div>
                    </div>

                </div>
            `;
        });
    }
    document.querySelector("#teacherCards").innerHTML = cards;
}

function renderTeacherPagination(totalPages, currentPage) {

    totalPages = Number(totalPages);
    currentPage = Number(currentPage);

    let html = "";

    // Prev Button
    html += `
        <button class="page-btn"
            ${currentPage === 1 ? "disabled" : ""}
            onclick="loadTeachers(${currentPage - 1})">
            Prev
        </button>
    `;

    let start = Math.max(1, currentPage - 2);
    let end = Math.min(totalPages, currentPage + 2);

    // First Page
    if (start > 1) {
        html += `
            <button class="page-btn"
                onclick="loadTeachers(1)">
                1
            </button>
        `;

        if (start > 2) {
            html += `<span>...</span>`;
        }
    }

    // Middle Pages
    for (let i = start; i <= end; i++) {

        if (totalPages <= 1) {
            document.querySelector("#pagination").innerHTML = "";
            return;
        }

        html += `
            <button
                class="page-btn ${i === currentPage ? "active" : ""}"
                onclick="loadTeachers(${i})">
                ${i}
            </button>
        `;
    }

    // Last Page
    if (end < totalPages) {

        if (end < totalPages - 1) {
            html += `<span>...</span>`;
        }

        html += `
            <button class="page-btn"
                onclick="loadTeachers(${totalPages})">
                ${totalPages}
            </button>
        `;
    }

    // Next Button
    html += `
        <button class="page-btn"
            ${currentPage === totalPages ? "disabled" : ""}
            onclick="loadTeachers(${currentPage + 1})">
            Next
        </button>
    `;

    document.querySelector("#pagination").innerHTML = html;
}

document.addEventListener("DOMContentLoaded", function () {
    loadTeachers(1);
});

document.querySelector("#desktopClassFilter")?.addEventListener("change", () => {
    loadTeachers(1);
});

document.querySelector("#desktopSectionFilter")?.addEventListener("change", () => {
    loadTeachers(1);
});

document.querySelector("#desktopGenderFilter")?.addEventListener("change", () => {
    loadTeachers(1);
});

document.addEventListener("DOMContentLoaded", function () {
    loadTeachers(1);
});

// for sync filter mobile to desktop
document.querySelector("#mobileClassFilter")
    ?.addEventListener("change", function () {

        document.querySelector("#desktopClassFilter").value =
            this.value;

    });

document.querySelector("#mobileSectionFilter")
    ?.addEventListener("change", function () {

        document.querySelector("#desktopSectionFilter").value =
            this.value;

    });

document.querySelector("#mobileGenderFilter")
    ?.addEventListener("change", function () {

        document.querySelector("#desktopGenderFilter").value =
            this.value;

    });

// for sync filter desktop to mobile
document.querySelector("#desktopClassFilter")
    ?.addEventListener("change", function () {

        document.querySelector("#mobileClassFilter").value =
            this.value;

    });

document.querySelector("#desktopSectionFilter")
    ?.addEventListener("change", function () {

        document.querySelector("#mobileSectionFilter").value =
            this.value;

    });

document.querySelector("#desktopGenderFilter")
    ?.addEventListener("change", function () {

        document.querySelector("#mobileGenderFilter").value =
            this.value;

    });

// apply filters
document.querySelector(".applyMobileFiltersBtn")
    ?.addEventListener("click", function () {

        // mobile values desktop mein copy
        document.querySelector("#desktopClassFilter").value =
            document.querySelector("#mobileClassFilter").value;

        document.querySelector("#desktopSectionFilter").value =
            document.querySelector("#mobileSectionFilter").value;

        document.querySelector("#desktopGenderFilter").value =
            document.querySelector("#mobileGenderFilter").value;

        // data reload
        loadTeachers(1);

        // bottom sheet close
        bottomFilter.classList.remove("open");

    });

// FOR RESET FILTERS
function resetFilter() {
    desktopClassFilter.value = "All";
    desktopSectionFilter.value = "All";
    desktopGenderFilter.value = "All";
    mobileClassFilter.value = "All";
    mobileGenderFilter.value = "All";
    mobileSectionFilter.value = "All";
    if (bottomFilter) {
        bottomFilter.classList.remove("open");
    }
    loadTeachers(1);
}

// Search Input par typing detect karne ke liye
let searchTeacherTimer;

// document.querySelector("#searchInput")?.addEventListener("keyup", function () {
//     // Purane timer ko clear karein taaki har lafz par request na jaye (Debounce)
//     clearTimeout(searchTeacherTimer);

//     // Jab user type karna roke tab 300ms baad search kare
//     searchTeacherTimer = setTimeout(() => {
//         loadTeachers(1);
//     }, 300);
// });

// FOR ADD TEACHER
let addTeacherBtn = document.querySelector("#Add_teacher_btn");
let teacherModal = document.querySelector("#teacherModal");

if (addTeacherBtn && teacherModal) {

    addTeacherBtn.addEventListener('click', function () {

        document.querySelector("#id-input").value = "";
        document.querySelector("#old-image").value = "";
        document.querySelector("#image-input").value = "";

        document.querySelector("#name-input").value = "";
        document.querySelector("#phone-input").value = "";
        document.querySelector("#address-input").value = "";
        document.querySelector("#email-input").value = "";
        document.querySelector("#genderDropdown").value = "Male";

        // show remove photo btn button
        let remove_photoBtn = document.querySelector(".remove-photo-btn");
        remove_photoBtn.style.display = "none";

        teacherModal.classList.add("open");
    })
}

let teacherForm = document.querySelector("#teacherForm");

if (teacherForm) {

    teacherForm.addEventListener("submit", function (e) {

        e.preventDefault();

        let teacherId = document.querySelector("#id-input").value;

        // ADD Teacher
        if (teacherId == "") {

            openConfirmBox(
                "Add Teacher",
                "Are you sure you want to add this teacher?",
                false,
                () => {
                    teacherForm.submit();
                }
            );

        }

        // UPDATE Teacher
        else {

            openConfirmBox(
                "Update Teacher",
                "Are you sure you want to update this Teacher?",
                false,
                () => {
                    teacherForm.submit();
                }
            );

        }

    });

}

// FOR UPDATE TEACHER
document.addEventListener("click", function (e) {
    let updateTeacherBtn = e.target.closest(".btn-action.edit.teacher");

    if (updateTeacherBtn && teacherModal) {
        console.log("Edit button clicked");

        let teacher_data_row = updateTeacherBtn.closest(".teacher-table-row");
        let teacherId = teacher_data_row.querySelector(".teacher-id-col").innerText;

        fetch("/student_management_system/admin/editTeacher.php?edit=" + teacherId)
            .then(response => response.json())
            .then(data => {

                document.querySelector(".card-picture").innerHTML =
                    `
                            <img src= "/student_management_system/${data.teacher_img}" class=""> 
                            <div class="avatar-overlay">
                                <i class="fa-solid fa-camera"></i>
                                <span>Change Photo</span>
                            </div>
                            `
                document.querySelector("#id-input").value = data.teacher_id;
                document.querySelector("#old-image").value = data.teacher_img;
                document.querySelector("#name-input").value = data.teacher_name;
                document.querySelector("#phone-input").value = data.teacher_phone_num;
                document.querySelector("#address-input").value = data.teacher_address;
                document.querySelector("#email-input").value = data.teacher_email;
                document.querySelector("#genderDropdown").value = data.teacher_gender;
                document.querySelector("#dob-input").value = data.teacher_dob;
                document.querySelector("#qualification-input").value = data.teacher_qualification;
                document.querySelector("#experience-input").value = data.teacher_experience_years;
                document.querySelector("#salary-input").value = data.teacher_salary;
                // document.querySelector("#maritalStatusDropdown-input").value = data.teacher_mariral_status;

                loadSections(
                    data.student_class,
                    data.student_section
                );

                // show remove photo btn button
                let remove_photoBtn = document.querySelector(".remove-photo-btn");
                remove_photoBtn.style.display = "flex";

                // open modal
                teacherModal.classList.add("open");
            })

    }

});// FOR DELETE
document.addEventListener("click", function (e) {

    let deleteTeacherBtn = e.target.closest(".delete.teacher");

    if (deleteTeacherBtn) {

        e.preventDefault();

        let deleteTeacherUrl = deleteTeacherBtn.getAttribute("href");

        openConfirmBox(
            "Delete Teacher",
            "Are you sure you want to delete this teacher?",
            true,
            () => {
                window.location.href = deleteTeacherUrl;
            }
        );

    }

});

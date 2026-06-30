let currentTab = "all";
let currentPage = 1;

// for tabs
document.addEventListener("DOMContentLoaded", () => {
    fetch("/school_management_system/teacher/APIs/get_teacher_assignments.php")
        .then(res => res.json())
        .then(data => {

            let studentData = data.data;
            let loginId = data.loginTeacher;

            let html = `
        <button class="assignment-tab active-tab" data-id="all">
            All Assignments
        </button>
    `;

            let check = false;
            studentData.forEach(row => {

                // for subject teacher
                if (loginId == row['subject_teacher']) {
                    html += `
                <button
                    class="assignment-tab"
                    data-id="${row.sec_id}">
                    Subject Teacher Of
                    Class ${row.class_id}-${row.section_name}
                    (${row.subject_name})
                </button>`
                }

                // for class teacher 
                if (loginId == row['class_teacher'] && (!check)) {
                    check = true;
                    console.log(check);
                    html += `
                <button
                    class="assignment-tab"
                    data-id="${row.sec_id}">
                    Class Teacher Of
                    ${row.class_id}-${row.section_name}
                    (${row.subject_name})
                </button>`

                }

            });

            let tabContainer = document.getElementById(
                "studentsAssignmentTabs"
            );
            tabContainer.innerHTML = html;

            // FOR ADD CLASS ACTIVE IN ASSIGNMENT TAB
            tabContainer.addEventListener("click", function (e) {

                if (e.target.classList.contains("assignment-tab")) {

                    document.querySelectorAll(".assignment-tab").forEach(tab => {
                        tab.classList.remove("active-tab");
                    });

                    e.target.classList.add("active-tab");

                    let sectionId = e.target.dataset.id;

                    if (sectionId === "all") {

                        currentTab = "all";
                        currentPage = 1;

                        loadAllStudents();

                    }
                    else {

                        currentTab = sectionId;
                        currentPage = 1;

                        loadTeacherStudents(sectionId);
                    }
                }

            });

        });

    loadAllStudents();

});

// for load student according to tab
function loadTeacherStudents(sectionId, page = 1) {

    let search =
        document.getElementById("searchInput").value;

    let gender =
        document.getElementById("desktopGenderFilter").value;

    fetch(
        `/school_management_system/teacher/APIs/get_students.php?secId=${sectionId}&page=${page}&search=${search}&gender=${gender}`
    )
        .then(res => res.json())
        .then(data => {

            renderTeacherTable(data.students);

            renderTeacherCards(data.students);

            renderTeacherPagination(
                data.totalPages,
                page
            );

            showToast("Studends of Assigned Classes And Subjects",
                "info",
                "Notice")
        });
}

function renderTeacherTable(data) {

    let html = "";

    data.forEach(student => {

        html += `
        <tr class="student-table-row">
            <td>${student.sid}</td>
            <td>
                <img class="student-img"
                src="/school_management_system/${student.images}">
            </td>
            <td>${student.name}</td>
            <td>${student.email}</td>
            <td>${student.gender}</td>
            <td>
                ${student.class_id}
                ${student.section_name}
            </td>
        </tr>
        `;
    });

    document.getElementById(
        "teacherStudentTable"
    ).innerHTML = html;
}

// CARD FOR SMALL SCREENS
function renderTeacherCards(data) {

    let card = "";

    data.forEach(student => {


        card += `
                <div class="student-mobile-card">

                <div class="card-top-bar">
                    <span class="card-student-id">${student.sid}</span>
                    <div class="card-top-actions">
                        <span class="status active" style="font-size:10px; padding:4px 10px;">${student.status}</span>

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
                    <img src="/school_management_system/${student.images}" class="student-img">
                    <div class="card-header-info">
                        <h4>${student.name}</h4>
                        <p>Class ${student.class_id} •
                            Sec ${student.section_name} • 
                            ${student.gender}
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
                                <span class="detail-value">${student.email}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Phone</span>
                                <span class="detail-value">${student.phone}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Address</span>
                                <span class="detail-value">${student.gender}</span>
                            </div>
                        </div>
                    </div>

                </div>
            `;

    });

    document.getElementById(
        "teacherStudentCards"
    ).innerHTML = card;
}

// LOAD ALL STUDENTS ACCORDING TO TEACHER ID
function loadAllStudents(page = 1) {

    let search =
        document.getElementById("searchInput").value;

    let gender =
        document.getElementById("desktopGenderFilter").value;

    fetch(
        `/school_management_system/teacher/APIs/get_all_students.php?page=${page}&search=${search}&gender=${gender}`
    )
        .then(res => res.json())
        .then(data => {

            renderTeacherTable(data.students);

            renderTeacherCards(data.students);

            renderTeacherPagination(
                data.totalPages,
                page
            );

        });

    showToast("All Students",
        "info",
        "Notice")
}

function loadCurrentTab(page = 1) {

    if (currentTab === "all") {

        loadAllStudents(page);

    } else {

        loadTeacherStudents(
            currentTab,
            page
        );
    }
}

// RENDER PAGINATION
function renderTeacherPagination(totalPages, currentPage) {

    totalPages = Number(totalPages);
    currentPage = Number(currentPage);

    let html = "";

    // Prev Button
    html += `
        <button class="page-btn"
            ${currentPage === 1 ? "disabled" : ""}
            onclick="loadCurrentTab(${currentPage - 1})">
            Prev
        </button>
    `;

    let start = Math.max(1, currentPage - 2);
    let end = Math.min(totalPages, currentPage + 2);

    // First Page
    if (start > 1) {
        html += `
            <button class="page-btn"
                onclick="loadCurrentTab(1)">
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
                onclick="loadCurrentTab(${i})">
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
                onclick="loadCurrentTab(${totalPages})">
                ${totalPages}
            </button>
        `;
    }

    // Next Button
    html += `
        <button class="page-btn"
            ${currentPage === totalPages ? "disabled" : ""}
            onclick="loadCurrentTab(${currentPage + 1})">
            Next
        </button>
    `;

    document.querySelector("#pagination").innerHTML = html;
}

document
    .getElementById("searchInput")
    ?.addEventListener("keyup", () => {

        loadCurrentTab(1);

    });

document
    .getElementById("desktopGenderFilter")
    ?.addEventListener("change", () => {

        loadCurrentTab(1);

    });

function resetFilter() {

    document.getElementById(
        "searchInput"
    ).value = "";

    document.getElementById(
        "desktopGenderFilter"
    ).value = "All";

    loadCurrentTab(1);
}
/* ==========================
   MOBILE SIDEBAR
========================== */

const menuToggle = document.getElementById("menuToggle");
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("sidebarOverlay");
const bottomFilter = document.querySelector("#bottomSheetOverlay");
const viewStudentModal = document.querySelector("#viewStudentModal");

if (menuToggle) {

    menuToggle.addEventListener("click", () => {

        sidebar.classList.toggle("show");
        overlay.classList.toggle("show");

    });

}

if (overlay) {

    overlay.addEventListener("click", () => {

        sidebar.classList.remove("show");
        overlay.classList.remove("show");

    });

}

/* ==========================
   DESKTOP COLLAPSE SIDEBAR
========================== */

const collapseBtn = document.getElementById("sidebarCollapseBtn");

if (collapseBtn) {

    collapseBtn.addEventListener("click", () => {

        sidebar.classList.toggle("collapsed");

        localStorage.setItem(
            "sidebarState",
            sidebar.classList.contains("collapsed")
        );

    });

}

window.addEventListener("DOMContentLoaded", () => {

    const savedState = localStorage.getItem("sidebarState");

    if (savedState === "true") {

        sidebar.classList.add("collapsed");

    }

});

// FOR ADD CLASS OPEN IN STUDENT MODAL
let addBtn = document.querySelector("#Add_btn");
let studentModal = document.querySelector("#studentModal");

if (addBtn && studentModal) {

    addBtn.addEventListener('click', function () {

        resetModal()

        document.querySelector("#id-input").value = "";
        document.querySelector("#old-image").value = "";
        document.querySelector("#image-input").value = "";

        document.querySelector("#name-input").value = "";
        document.querySelector("#age-input").value = "";
        document.querySelector("#phone-input").value = "";
        document.querySelector("#address-input").value = "";
        document.querySelector("#email-input").value = "";
        document.querySelector(".selectClass").value = "All";
        document.querySelector("#genderDropdown").value = "Male";
        document.querySelector("#statusDropdown").value = "Active";
        // document.querySelector("#sectionDropdown").value = "select-class";


        // show remove photo btn button
        let remove_photoBtn = document.querySelector(".remove-photo-btn");
        remove_photoBtn.style.display = "none";

        studentModal.classList.add("open");
    })
}

function resetModal() {
    document.querySelector("#studentSection").innerHTML = `
     <option disabled selected value="All">Select Class First</option>
    `
}

// section dropdown
function loadSections(classId, selectedSection = null) {

    fetch("sectionDropdown.php?classId=" + classId)
        .then(response => response.json())
        .then(data => {

            let sectionDropdown = document.querySelector("#studentSection");

            if (sectionDropdown) {
                sectionDropdown.innerHTML = "";
            }

            data.forEach(item => {
                console.log(item.section_name);

                sectionDropdown.innerHTML += `
                    <option value="${item.sec_id}">
                        ${item.section_name}
                    </option>
                `;
            });

            if (selectedSection) {
                sectionDropdown.value = selectedSection;
            }

        });
}


// FOR ADD CLASS OPEN IN ADD SECTION MODAL
let addSection = document.querySelector("#Add_section_btn");
let sectionModal = document.querySelector("#addSection");

if (addSection && sectionModal) {

    addSection.addEventListener('click', function () {

        sectionModal.classList.add("open");
    })

}

document.addEventListener("DOMContentLoaded", function () {
    let addSectionForm = document.querySelector("#addsectionModal");

    if (addSectionForm) {
        addSectionForm.addEventListener("submit", function (e) {

            e.preventDefault();

            openConfirmBox(
                "Add Section",
                "Are you sure you want to add this section?",
                false,
                () => {
                    addSectionForm.submit();
                }
            );
        })
    }
})


// FOR ADD CLASS OPEN IN SECTION DETAIL MODAL AND FETCH DATA
let sec_DetailBtn = document.querySelectorAll(".section-detail-trigger");
let sec_detailModal = document.querySelector("#sectionDetail");

sec_DetailBtn.forEach(btn => {

    btn.addEventListener('click', function () {

        let classId = this.dataset.classId;

        fetch("/school_management_system/admin/APIs/get_class_details.php?class_id=" + classId)

            .then(response => response.json())

            .then(data => {

                // modal title
                document.querySelector("#sectionsModalTitle")
                    .innerHTML = "Academic Structure: Class " + data.class;

                // list container
                let container = document.querySelector(".modal-section-list");

                container.innerHTML = "";

                // loop all sections
                data.sections.forEach(section => {

                    container.innerHTML += `
                    
                    <div class="modal-section-item">

                        <span>
                            <i class="fa-solid fa-circle-notch"
                            style="color:var(--accent-theme-color, #2563eb); margin-right:10px;"></i>

                            <strong>Section ${section.section_name}</strong>
                             ${section.teacher_name}
                        </span>

                        <span style="font-size:11px; background: rgba(0,0,0,0.05); padding: 4px 10px; border-radius: 999px;">${section.total_students}</span>

                    </div>

                    `;

                });

                // open modal
                sec_detailModal.classList.add("open");

            });

    });

});

// FOR ADD CLASS OPEN IN SUBJECT LIST MODAL AND FETCH DATA
let subject_TeacherModal = document.querySelector("#subject-list-Modal");
document.querySelectorAll(".subject-teacher-list-trigger").forEach(btn => {
    btn.addEventListener('click', function () {


        // select class card
        let card = this.closest('.class-card');
        let activeSectionBtn = card.querySelector(".section-switch-btn.active");

        // to get class name
        let className = card.querySelector(".class-card-name").innerText;


        // to get section-id
        let sectionId = activeSectionBtn.dataset.sectionId;
        let sectionName = activeSectionBtn.innerText;

        document.querySelector("#subject-list-title")
            .innerText = className + " (Section" + sectionName + ")";

        // fetch data
        fetch("/school_management_system/admin/APIs/get_subject_teachers.php?section_id=" + sectionId)

            .then(response => response.json())
            .then(data => {

                // TO GET CONTAINER
                let container = document.querySelector(".modal-subject-teacher-list");
                container.innerHTML = "";

                data.forEach(item => {

                    // TO ADD DATA IN CONTAINER
                    container.innerHTML += `
                    <div class = "subject-teacher-item">

                    <div class= "subject-name-tag">
                    <i class="fa-solid fa-book-open"></i>
                    <span>${item.subject_name}</span>
                    </div>

                    <div style="display: flex; gap: 8px; align-items:center; justify-content: space-between;" >
                    <div class="subject-teacher-div"><span>${item.name}</span></div>
                    <div style="display: flex; gap:10px;">
                    <button class="btn-action edit"><i class="fa-solid fa-pen"></i></button>
                    <button class="btn-action delete"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    
                    </div>

                    </div>
                    `

                })

                // add class open
                subject_TeacherModal.classList.add("open")
            })
    })
});

// FOR REMOVE CLASS CLOSE IN MODALs
let closeModal = () => {

    if (sectionModal) {
        sectionModal.classList.remove("open");
    }

    if (studentModal) {
        studentModal.classList.remove("open");
        resetModal();
    }

    if (sec_detailModal) {
        sec_detailModal.classList.remove("open");
    }

    if (subject_TeacherModal) {
        subject_TeacherModal.classList.remove("open");
    }

    if (typeof teacherModal !== "undefined" && teacherModal) {
        teacherModal.classList.remove("open");
    }

    if (viewStudentModal) {
        viewStudentModal.classList.remove("open");
    }

    if (typeof viewTeacherModal !== "undefined" && viewTeacherModal) {
        viewTeacherModal.classList.remove("open");
    }

}

// if (desktopSection) {
//     desktopSection.addEventListener("change", function () {
//         mobileSection.value = this.value;
//     })
// }

// if (desktopGender) {
//     desktopGender.addEventListener("change", function () {
//         mobileGender.value = this.value;
//     })
// }

// FOR MOBILE
// if (mobileClass) {
//     mobileClass.addEventListener("change", function () {

//         desktopClass.value = this.value;

//     });
// }

// if (mobileSection) {
//     mobileSection.addEventListener("change", function () {
//         desktopSection.value = this.value;
//     })
// }

// if (mobileGender) {
//     mobileGender.addEventListener("change", function () {
//         desktopGender.value = this.value;
//     })
// }

// function resetFilter() {

//     let rows = document.querySelectorAll("#studentTable tbody tr");

//     let searchInput = searchValue.value = "";
//     let classFilter = document.querySelector(".classFilter").value = "All";
//     let genderFilter = document.querySelector("#desktopGenderFilter").value = "All";

//     rows.forEach(row => {
//         row.style.display = "";
//     })
// }

// ---------To Add Dynamic Content in Card Class----------
document.querySelectorAll(".section-switch-btn").forEach(button => {

    button.addEventListener('click', function () {

        let sectionId = this.dataset.sectionId;
        let classId = this.dataset.classId;

        fetch("/school_management_system/admin/APIs/get_section_data.php?section_id=" + sectionId + "&class_id=" + classId)

            .then(response => response.json())

            .then(data => {

                // find correct card
                let card = document.querySelector(
                    `.class-card[data-card-class="${classId}"]`
                );

                // update capacity text
                card.querySelector(".card-progress-meta span:last-child")
                    .innerHTML = data.students + " / " + data.capacity;

                // update progress bar
                card.querySelector(".card-progress-fill")
                    .style.width = data.percent + "%";

                // Add class teacher name
                card.querySelector(".class-teacher")
                    .innerHTML = data.class_teacher;

                // update total students
                card.querySelector(".total-student-card")
                    .innerHTML = data.students;

                // update total subjects
                card.querySelector(".total-subjects-card")
                    .innerHTML = data.total_subjects;
            })


    });

});



// SET SECTION A VALUE ON PAGE LOAD
let class_cards = document.querySelectorAll(".class-card");
class_cards.forEach(card => {

    let firstButton = card.querySelector(".section-switch-btn");

    if (firstButton) {

        firstButton.click();

    }

});

// FOR ADD CLASS ACTIVE IN SECTION BUTTONS
class_cards.forEach(card => {

    let sectionBtns = card.querySelectorAll(".section-switch-btn");
    sectionBtns.forEach(sectionBtn => {

        sectionBtn.addEventListener('click', function () {

            sectionBtns.forEach(btn => {
                btn.classList.remove("active");
            })

            this.classList.add("active");
        })
    })
})

// to apply different color on every card
const theme = [
    { color: "#3b82f6", glow: "rgba(59, 130, 246, 0.25)", bg: "rgba(59, 130, 246, 0.08)", gradient: "linear-gradient(135deg, #3b82f6, #1d4ed8)" },
    { color: "#a855f7", glow: "rgba(168, 85, 247, 0.25)", bg: "rgba(168, 85, 247, 0.08)", gradient: "linear-gradient(135deg, #a855f7, #7e22ce)" },
    { color: "#06b6d4", glow: "rgba(6, 182, 212, 0.25)", bg: "rgba(6, 182, 212, 0.08)", gradient: "linear-gradient(135deg, #06b6d4, #0891b2)" },
    { color: "#10b981", glow: "rgba(16, 185, 129, 0.25)", bg: "rgba(16, 185, 129, 0.08)", gradient: "linear-gradient(135deg, #10b981, #047857)" },
    { color: "#ec4899", glow: "rgba(236, 72, 153, 0.25)", bg: "rgba(236, 72, 153, 0.08)", gradient: "linear-gradient(135deg, #ec4899, #be185d)" },
    { color: "#f59e0b", glow: "rgba(245, 158, 11, 0.25)", bg: "rgba(245, 158, 11, 0.08)", gradient: "linear-gradient(135deg, #f59e0b, #b45309)" }
];

class_cards.forEach((card, index) => {

    const cardTheme = theme[index % theme.length];

    card.style.setProperty('--accent-theme-color', cardTheme.color);
    card.style.setProperty('--accent-theme-gradient', cardTheme.gradient);
    card.style.setProperty('--accent-theme-glow', cardTheme.glow);
    // cardTheme.style.setProperty('--accent-theme-color', theme.color);

})

// FOR APPLY DIFFERENT COLOR ON HORIZONTAL BAR IN CLASSES PAGE
const horizontalBar = document.querySelectorAll(".chart-fill");

horizontalBar.forEach((bar, index) => {

    const barTheme = theme[index % theme.length];

    bar.style.setProperty('--primary-gradient', barTheme.color);

})

/* ==============================================
// TO SHOW IMAGE BEFORE UPLOAD
   IMAGE UPLOAD & PREVIEW (STUDENT & TEACHER)
================================================= */

// 1. STUDENT IMAGE HANDLER
let studentCardPicture = document.querySelector("#student-card-picture");
let studentImageInput = document.querySelector(".student-image-input");

if (studentCardPicture && studentImageInput) {
    studentCardPicture.addEventListener('click', function () {
        studentImageInput.click();
    });

    studentImageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            studentCardPicture.innerHTML = `
                <img src="${URL.createObjectURL(file)}" class=""> 
                <div class="avatar-overlay">
                    <i class="fa-solid fa-camera"></i>
                    <span>Change Photo</span>
                </div>
            `;
            let removeBtn = studentCardPicture.closest('.profile-wrapper').querySelector(".remove-photo-btn");
            if (removeBtn) removeBtn.style.display = "flex";
        }
    });
}

// 2. TEACHER IMAGE HANDLER
let teacherCardPicture = document.querySelector("#teacher-card-picture");
let teacherImageInput = document.querySelector(".teacher-image-input");

if (teacherCardPicture && teacherImageInput) {
    teacherCardPicture.addEventListener('click', function () {
        teacherImageInput.click();
    });

    teacherImageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            teacherCardPicture.innerHTML = `
                <img src="${URL.createObjectURL(file)}" class=""> 
                <div class="avatar-overlay">
                    <i class="fa-solid fa-camera"></i>
                    <span>Change Photo</span>
                </div>
            `;
            let removeBtn = teacherCardPicture.closest('.profile-wrapper').querySelector(".remove-photo-btn");
            if (removeBtn) removeBtn.style.display = "flex";
        }
    });
}

// 3. RESET IMAGE FUNCTION 
function resetImage() {

    // Student reset
    let sPic = document.querySelector("#student-card-picture");

    if (sPic) {
        sPic.innerHTML = `<i class="fa-solid fa-user"></i><div class="avatar-overlay"><i class="fa-solid fa-camera"></i><span>Upload Photo</span></div>`;
    }

    // Teacher reset
    let tPic = document.querySelector("#teacher-card-picture");

    if (tPic) {
        tPic.innerHTML = `<i class="fa-solid fa-user"></i><div class="avatar-overlay"><i class="fa-solid fa-camera"></i><span>Upload Photo</span></div>`;
    }

    // Profile reset 
    let profilecards = document.querySelectorAll(".card-picture.profile");
    profilecards.forEach(profileCard => {
        profileCard.innerHTML = `<i class="fa-solid fa-user"></i><div class="avatar-overlay"><i class="fa-solid fa-camera"></i><span>Upload Photo</span></div>`;
    })

    // Hide remove buttons
    document.querySelectorAll(".remove-photo-btn").forEach(btn => btn.style.display = "none");
}

// To make section dropdown dynamically
let selectClass = document.querySelector(".selectClass");

if (selectClass) {

    selectClass.addEventListener('change', function () {

        loadSections(this.value);

    })

}


// CONFIRM DIALOGUE BOX
let pendingConfirmCallback = null;

function openConfirmBox(title, message, isDanger, callback) {

    const mainWrapper = document.querySelector('#custom-confirm-wrapper');
    const modal = document.querySelector('.custom-confirm-box');
    const titleEl = document.querySelector('#confirmTitle');
    const msgEl = document.querySelector('#confirmMessage');
    const icon = document.querySelector('#confirmIcon');
    const iconWrapper = document.querySelector('.confirm-icon-wrapper');
    const okBtn = document.querySelector('#confirmOkBtn');

    // text set
    titleEl.innerText = title;
    msgEl.innerText = message;

    // style based on danger or normal
    if (isDanger) {
        icon.className = "fa-solid fa-triangle-exclamation";
        iconWrapper.style.background = "rgba(239,68,68,0.1)";
        iconWrapper.style.color = "#ef4444";
        okBtn.style.background = "#ef4444"
        okBtn.innerText = "Yes, Delete";
    } else {
        icon.className = "fa-solid fa-circle-info";
        iconWrapper.style.background = "rgba(99,102,241,0.1)";
        iconWrapper.style.color = "#6366f1";
        okBtn.style.background = "var(--primary-gradient)"
        okBtn.innerText = "Confirm";
    }

    // save callback
    pendingConfirmCallback = callback;

    // show modal
    mainWrapper.classList.add('open');
}

// CONFIRM CANCEL
let cancelBtn = document.querySelector('#confirmCancelBtn');
if (cancelBtn) {
    cancelBtn.addEventListener('click', () => {
        document.querySelector('#custom-confirm-wrapper').classList.remove('open');
        pendingConfirmCallback = null;
    });

}

// CONFIRM OK
let confirmOKBtn = document.querySelector('#confirmOkBtn');

if (confirmOKBtn) {

    confirmOKBtn.addEventListener('click', () => {
        document.querySelector('.custom-confirm-box').classList.remove('open');

        if (pendingConfirmCallback) {
            pendingConfirmCallback();
            pendingConfirmCallback = null;
        }
    });

}

let studentForm = document.querySelector("#studentForm");

if (studentForm) {

    studentForm.addEventListener("submit", function (e) {

        e.preventDefault();

        let studentId = document.querySelector("#id-input").value;

        // ADD STUDENT
        if (studentId == "") {

            openConfirmBox(
                "Add Student",
                "Are you sure you want to add this student?",
                false,
                () => {
                    studentForm.submit();
                }
            );

        }

        // UPDATE STUDENT
        else {

            openConfirmBox(
                "Update Student",
                "Are you sure you want to update this student?",
                false,
                () => {
                    studentForm.submit();
                }
            );

        }

    });

}

// Toast Alert 
function showToast(message, type = 'success', title = '') {
    const container = document.getElementById('toastContainer');
    if (!container) return;

    if (!title) {
        if (type === 'success') title = "Operation Successful";
        if (type === 'error') title = "System Warning";
        if (type === 'info') title = "Notification Info";
    }

    let icon = "fa-circle-check";
    if (type === 'error') icon = "fa-triangle-exclamation";
    if (type === 'info') icon = "fa-circle-info";

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
                <div class="toast-icon"><i class="fa-solid ${icon}"></i></div>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
                <button class="toast-close"><i class="fa-solid fa-xmark"></i></button>
                <div class="toast-progress">
                    <div class="toast-progress-fill" style="animation-duration: 4000ms;"></div>
                </div>
            `;

    container.appendChild(toast);
    setTimeout(() => toast.classList.add('toast-show'), 15);

    const autoClose = setTimeout(() => hideToast(toast), 4000);

    toast.querySelector('.toast-close').addEventListener('click', () => {
        clearTimeout(autoClose);
        hideToast(toast);
    });
}

function hideToast(toast) {
    toast.classList.remove('toast-show');
    toast.classList.add('toast-hide');
    toast.addEventListener('transitionend', () => toast.remove());
}

// DYNAMIC SECTION DROPDOWN FOR ATTENDANCE PAGE

document.addEventListener("DOMContentLoaded", function () {

    let attendanceClassFilter = document.querySelectorAll(".classFilter");

    if (attendanceClassFilter) {

        attendanceClassFilter.forEach(filter => {

            filter.addEventListener('change', function () {
                let classId = this.value;

                let attendanceSectionDropdown = document.querySelectorAll(".sectionDropdown");
                attendanceSectionDropdown.forEach(dropDown => {
                    if (!attendanceSectionDropdown) return;

                    if (classId === "All" || classId === "") {
                        dropDown.innerHTML = '<option value="All" disabled selected>Select Class First</option>';
                        return;
                    }

                    // AJAX/Fetch call to load sections for Attendance page
                    fetch("sectionDropdown.php?classId=" + classId)
                        .then(response => response.json())
                        .then(data => {

                            dropDown.innerHTML = '<option value="All" selected disabled>All Sections</option>';

                            data.forEach(item => {
                                dropDown.innerHTML += `
                            <option value="${item.sec_id}" class="section-option">
                                ${item.section_name}
                            </option>
                        `;
                            });
                        })
                        .catch(err => console.error("Error fetching attendance sections:", err));
                })

            });

        })

    }

});

// FOR BOTTOM FILTER SHEET
let filterBtn = document.querySelector(".mobile-filter-trigger");

if (bottomFilter && filterBtn) {
    filterBtn.addEventListener('click', function () {
        bottomFilter.classList.add("open");
    })
}

// for apply filter and pagination
function loadStudents(page = 1) {

    let search = document.querySelector("#searchInput")?.value;
    let classFilter = document.querySelector("#desktopClassFilter")?.value || "All";
    let sectionFilter = document.querySelector("#desktopSectionFilter")?.value || "All";
    let genderFilter = document.querySelector("#desktopGenderFilter")?.value || "All";

    fetch(`/school_management_system/admin/APIs/load_students.php/?page=${page}&search=${search}&class=${classFilter}&section=${sectionFilter}&gender=${genderFilter}`)
        .then(res => res.json())
        .then(data => {

            renderTable(data.data);

            renderCard(data.data);

            let paginationInfo = document.querySelector(".pagination-info");
            if (paginationInfo) {
                paginationInfo.innerHTML = `
            Showing Page ${data.currentPage} of ${data.totalPages} (${data.totalRecords} Students)
            `;
            }

            renderPagination(
                data.totalPages,
                data.currentPage
            );
        })
}

function renderTable(data) {

    let table = `
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
        table += `
            <tr>
                <td colspan="5" style="text-align:center;">
                    No records found
                </td>
            </tr>
        `;
    } else {

        data.forEach(student => {
            table += `
                <tr class="student-table-row">
                    <td class="student-id-col">${student.sid}</td>
                    <td><img class="student-img" src="/school_management_system/${student.images}"></td>
                    <td>${student.name}</td>
                    <td>
                    <div class="contact-cell">
                                            <h5>${student.email}</h5>
                                            <span>${student.phone}</span>
                                        </div>
                    </td>
                    <td>${student.gender}</td>
                    <td>${student.address}</td>
                    <td>${student.class_id}
                    ${student.section_name}
                    </td>
                    <td> 
                    <span class="status ${student.status === "Active" ? "active" : ""}">${student.status}</span></td>
                    <td>
                    <div class="btns-action">
                    <button type="button" class="btn-action view view-student-details-btn" 
                            title="View Details">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                        <button class="btn-action edit" title="Edit"><i class="fa-solid fa-pen"></i></button>
                        <a class="btn-action delete delete-btn" href="deletephp.php?delete=${student.sid}" title="Delete"><i class="fa-solid fa-trash"></i></a>
                    </div>
                    </td>
                </tr>
            `;
        });
    }

    table += `
            </tbody>
        </table>
    `;

    let studentTable = document.querySelector("#studentTable");

    if (studentTable) {
        studentTable.innerHTML = table;
    }
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
        data.forEach(student => {

            cards += `
                <div class="student-mobile-card">

                <div class="card-top-bar">
                    <span class="card-student-id">${student.sid}</span>
                    <div class="card-top-actions">
                        <span class="status active" style="font-size:10px; padding:4px 10px;">${student.status}</span>

                        <button class="card-options-trigger">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <div class="card-options-dropdown" id="dropdown">

                            <button type="button" class="dropdown-opt opt-view view" 
                                    title="View Details">
                                <i class="fa-solid fa-eye"></i> View Details
                            </button>

                            <button class="dropdown-opt opt-edit mobile-edit-btn" style="color:#2563eb;"
                                    data-id="${student.sid}">
                                <i class="fa-solid fa-pen"></i> Edit Student
                            </button>

                            <button class="dropdown-opt opt-delete mobile-delete-btn"
                                    data-id="${student.sid}">
                                <i class="fa-solid fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-header-flex">
                    <img src="/school_management_system/${student.images}" class="student-img active-border">
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
    }

    let studentCards = document.querySelector("#studentCards");

    if (studentCards) {
        studentCards.innerHTML = cards;
    }
}

function renderPagination(totalPages, currentPage) {

    totalPages = Number(totalPages);
    currentPage = Number(currentPage);

    let html = "";

    // Prev Button
    html += `
        <button class="page-btn"
            ${currentPage === 1 ? "disabled" : ""}
            onclick="loadStudents(${currentPage - 1})">
            Prev
        </button>
    `;

    let start = Math.max(1, currentPage - 2);
    let end = Math.min(totalPages, currentPage + 2);

    // First Page
    if (start > 1) {
        html += `
            <button class="page-btn"
                onclick="loadStudents(1)">
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
                onclick="loadStudents(${i})">
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
                onclick="loadStudents(${totalPages})">
                ${totalPages}
            </button>
        `;
    }

    // Next Button
    html += `
        <button class="page-btn"
            ${currentPage === totalPages ? "disabled" : ""}
            onclick="loadStudents(${currentPage + 1})">
            Next
        </button>
    `;

    document.querySelector("#pagination").innerHTML = html;
}

let desktopClassFilter = document.querySelector("#desktopClassFilter");
let desktopSectionFilter = document.querySelector("#desktopSectionFilter");
let desktopGenderFilter = document.querySelector("#desktopGenderFilter");
let mobileClassFilter = document.querySelector("#mobileClassFilter");
let mobileSectionFilter = document.querySelector("#mobileSectionFilter");
let mobileGenderFilter = document.querySelector("#mobileGenderFilter");

let searchTimer;

document.querySelector("#searchInput")
    ?.addEventListener("keyup", function () {

        clearTimeout(searchTimer);

        searchTimer = setTimeout(() => {
            loadStudents(1);
            loadTeachers(1);
        }, 300);

    });

document.querySelector("#desktopClassFilter")?.addEventListener("change", () => {
    loadStudents(1);
});

document.querySelector("#desktopSectionFilter")?.addEventListener("change", () => {
    loadStudents(1);
});

document.querySelector("#desktopGenderFilter")?.addEventListener("change", () => {
    loadStudents(1);
});

document.addEventListener("DOMContentLoaded", function () {
    loadStudents(1);
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
        loadStudents(1);

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
    loadStudents(1);
}

// FOR UPDATE DATA OF STUDENTS (BOTH DESKTOP & MOBILE)
document.addEventListener("click", function (e) {

    let updateBtn = e.target.closest(".btn-action.edit") || e.target.closest(".opt-edit");

    if (updateBtn && studentModal) {

        let studentId = "";

        // Check karein ke click desktop row par hua hai ya mobile card par
        if (updateBtn.closest(".student-table-row")) {
            let student_data_row = updateBtn.closest(".student-table-row");
            studentId = student_data_row.querySelector(".student-id-col").innerText;
        } else if (updateBtn.closest(".student-mobile-card")) {
            let student_card = updateBtn.closest(".student-mobile-card");
            studentId = student_card.querySelector(".card-student-id").innerText;
        }

        if (studentId) {
            fetch("/school_management_system/admin/APIs/editStudent.php?edit=" + studentId)
                .then(response => response.json())
                .then(data => {
                    document.querySelector("#student-card-picture").innerHTML = `
                        <img src= "/school_management_system/${data.student_img}" class=""> 
                        <div class="avatar-overlay">
                            <i class="fa-solid fa-camera"></i>
                            <span>Change Photo</span>
                        </div>
                    `;
                    document.querySelector("#id-input").value = data.student_id;
                    document.querySelector("#old-image").value = data.student_img;
                    document.querySelector("#name-input").value = data.student_name;
                    document.querySelector("#age-input").value = data.student_age;
                    document.querySelector("#phone-input").value = data.student_phone_num;
                    document.querySelector("#address-input").value = data.student_address;
                    document.querySelector("#email-input").value = data.student_email;
                    document.querySelector(".selectClass").value = data.student_class;
                    document.querySelector("#genderDropdown").value = data.student_gender;
                    document.querySelector("#statusDropdown").value = data.student_status;

                    loadSections(data.student_class, data.student_section);

                    let remove_photoBtn = document.querySelector(".remove-photo-btn");
                    remove_photoBtn.style.display = "flex";

                    // FOR CHANGE HEADER HEADING OF UPDATE
                    let headings = document.querySelectorAll(".modal-heading");
                    headings.forEach((heading) => {
                        heading.innerText = "Edit Student Profile";
                    });

                    // Form open modal
                    studentModal.classList.add("open");
                });
        }
    }
});

// FOR DELETE (BOTH DESKTOP & MOBILE)
document.addEventListener("click", function (e) {
    let deleteBtn = e.target.closest(".delete-btn");
    let mobileDeleteBtn = e.target.closest(".dropdown-opt.opt-delete");

    if (deleteBtn || mobileDeleteBtn) {
        e.preventDefault();
        let deleteUrl = "";

        if (deleteBtn) {

            deleteUrl = deleteBtn.getAttribute("href");

        } else if (mobileDeleteBtn) {

            let card = mobileDeleteBtn.closest(".student-mobile-card");
            let studentId = card.querySelector(".card-student-id").innerText;
            deleteUrl = "deletephp.php?delete=" + studentId;

        }

        if (deleteUrl) {
            openConfirmBox(
                "Delete Student",
                "Are you sure you want to delete this student?",
                true,
                () => {
                    window.location.href = deleteUrl;
                }
            );
        }
    }
});


// FOR STUDENT CARD DETAIL BUTTON
document.addEventListener("click", function (e) {

    let studentDetailBtn = e.target.closest(".card-accordion-toggle");

    if (!studentDetailBtn) return;

    let card = studentDetailBtn.closest(".student-mobile-card");

    let content = card.querySelector(".card-accordion-content");
    let text = studentDetailBtn.querySelector(".toggle-text");
    let icon = studentDetailBtn.querySelector("i");

    content.classList.toggle("show");
    icon.classList.toggle("rotate");

    if (content.classList.contains("show")) {
        text.innerText = "Hide Details";
    } else {
        text.innerText = "View Details";
    }

})

// FOR OPEN USER profile
let profileContainer = document.querySelectorAll(".user-profile-container");
console.log(profileContainer);


if (profileContainer) {

    profileContainer.forEach(container => {
        container.addEventListener('click', function () {
            let profileMenu = container.querySelector(".profile-dropdown-menu");
            profileMenu.classList.toggle("show");
        })
    })

}

// FOR STUDENT CARD 3 DOT MENU
document.addEventListener("click", function (e) {

    let trigger = e.target.closest(".card-options-trigger");

    // agar 3 dot button click hua
    if (trigger) {

        let dropdown = trigger.parentElement.querySelector(".card-options-dropdown");

        document.querySelectorAll(".card-options-dropdown").forEach(item => {
            if (item !== dropdown) {
                item.classList.remove("show");
            }
        });

        dropdown.classList.toggle("show");
        return;
    }

    document.querySelectorAll(".card-options-dropdown").forEach(item => {
        item.classList.remove("show");
    });

});

// FOR OPEN ADD STUDENT MODAL IN SMALL SCREENS
let mobileAddBtn = document.querySelector(".add-mobile-btn");

if (mobileAddBtn && studentModal) {
    mobileAddBtn.addEventListener("click", function () {

        resetModal();

        document.querySelector("#id-input").value = "";
        document.querySelector("#old-image").value = "";
        document.querySelector("#image-input").value = "";

        document.querySelector("#name-input").value = "";
        document.querySelector("#age-input").value = "";
        document.querySelector("#phone-input").value = "";
        document.querySelector("#address-input").value = "";
        document.querySelector("#email-input").value = "";
        document.querySelector(".selectClass").value = "All";
        document.querySelector("#genderDropdown").value = "Male";
        document.querySelector("#statusDropdown").value = "Active";

        let remove_photoBtn = document.querySelector(".remove-photo-btn");
        if (remove_photoBtn) {
            remove_photoBtn.style.display = "none";
        }

        resetImage();

        // Modal open karein
        studentModal.classList.add("open");
    })
}

/* ==============================================
   VIEW STUDENT DETAILS POPUP
================================================= */

document.addEventListener("click", function (e) {

    let btn = e.target.closest(".view-student-details-btn") || e.target.closest(".opt-view");

    if (!btn) return;

    let studentId = "";

    // Desktop table
    if (btn.closest(".student-table-row")) {
        let studentRow = btn.closest(".student-table-row");
        studentId = studentRow.querySelector(".student-id-col").innerText;
    }
    // Mobile card
    else if (btn.closest(".student-mobile-card")) {
        let studentCard = btn.closest(".student-mobile-card");
        studentId = studentCard.querySelector(".card-student-id").innerText;
    }

    if (studentId) {

        fetch("/school_management_system/admin/APIs/editStudent.php?edit=" + studentId)
            .then(response => response.json())
            .then(data => {

                document.getElementById("view-student-name").innerText = data.student_name;
                document.getElementById("view-student-email").innerText = data.student_email || "N/A";
                document.getElementById("view-student-phone").innerText = data.student_phone_num;
                document.getElementById("view-student-age").innerText = data.student_age;
                document.getElementById("view-student-class").innerText = data.student_class;
                document.getElementById("view-student-section").innerText = data.student_section;
                document.getElementById("view-student-gender").innerText = data.student_gender;
                document.getElementById("view-student-address").innerText = data.student_address;

                // Status configuration
                let statusTag = document.getElementById("view-student-status");
                statusTag.innerText = data.student_status;

                if (data.student_status === "Active") {
                    statusTag.style.background = "rgba(16, 185, 129, 0.12)";
                    statusTag.style.color = "#10b981";
                } else {
                    statusTag.style.background = "rgba(100, 116, 139, 0.12)";
                    statusTag.style.color = "#64748b";
                }

                // Image handling
                let imgContainer = document.getElementById("view-student-img-container");
                if (data.student_img) {
                    imgContainer.innerHTML = `
                        <img src="/school_management_system/${data.student_img}">
                    `;
                } else {
                    imgContainer.innerHTML = `
                        <i class="fa-solid fa-user" style="font-size:40px;"></i>
                    `;
                }

                // Open Modal
                document.getElementById("viewStudentModal").classList.add("open");
            });
    }
});


// Outside click parser to close unified view modal
window.addEventListener("click", function (e) {
    let viewModal = document.getElementById("viewStudentModal");
    if (e.target === viewModal) {
        closeModal();
    }
});


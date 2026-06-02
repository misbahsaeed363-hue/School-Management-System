// FOR ADD CLASS OPEN IN STUDENT MODAL
let addBtn = document.querySelector("#Add_btn");
let studentModal = document.querySelector("#studentModal");

if (addBtn && studentModal) {

    addBtn.addEventListener('click', function () {

        document.querySelector("#id-input").value = "";
        document.querySelector("#old-image").value = "";
        document.querySelector("#image-input").value = "";

        studentModal.classList.add("open");
    })
}

// section dropdown
function loadSections(classId, selectedSection = null) {

    fetch("sectionDropdown.php?classId=" + classId)
        .then(response => response.json())
        .then(data => {

            let sectionDropdown = document.querySelector("#sectionDropdown");

            sectionDropdown.innerHTML = "";

            data.forEach(item => {

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

// for update student data
let updateBtn = document.querySelectorAll(".btn-action.edit");

if (updateBtn && studentModal) {

    updateBtn.forEach(btn => {

        btn.addEventListener('click', function () {

            let student_data_row = this.closest(".student-table-row");
            let studentId = student_data_row.querySelector(".student-id-col").innerText;

            fetch("editStudent.php?edit=" + studentId)
                .then(response => response.json())
                .then(data => {

                    document.querySelector(".card-picture").innerHTML =
                        `
                    <img src= "${data.student_img}" class=""> 
                    <div class="avatar-overlay">
                        <i class="fa-solid fa-camera"></i>
                        <span>Change Photo</span>
                    </div>
                    `
                    document.querySelector("#id-input").value = data.student_id;
                    document.querySelector("#old-image").value = data.student_img;
                    document.querySelector("#name-input").value = data.student_name;
                    document.querySelector("#age-input").value = data.student_age;
                    document.querySelector("#phone-input").value = data.student_phone_num;
                    document.querySelector("#address-input").value = data.student_address;
                    document.querySelector("#email-input").value = data.student_email;
                    document.querySelector("#selectClass").value = data.student_class;
                    document.querySelector("#genderDropdown").value = data.student_gender;
                    document.querySelector("#statusDropdown").value = data.student_status;

                    document.querySelector("#selectClass").value = data.student_class;

                    loadSections(
                        data.student_class,
                        data.student_section
                    );

                    // show remove photo btn button
                    let remove_photoBtn = document.querySelector(".remove-photo-btn");
                    remove_photoBtn.style.display = "flex";

                    // open modal
                    studentModal.classList.add("open");
                })

        })

    })


}


// FOR ADD CLASS OPEN IN ADD SECTION MODAL
let addSection = document.querySelector("#Add_section_btn");
let sectionModal = document.querySelector("#addSection");

if (addSection && sectionModal) {

    addSection.addEventListener('click', function () {
        sectionModal.classList.add("open");
    })

}

// FOR ADD CLASS OPEN IN SECTION DETAIL MODAL AND FETCH DATA
let sec_DetailBtn = document.querySelectorAll(".section-detail-trigger");
let sec_detailModal = document.querySelector("#sectionDetail");

sec_DetailBtn.forEach(btn => {

    btn.addEventListener('click', function () {

        let classId = this.dataset.classId;

        fetch("get_class_details.php?class_id=" + classId)

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
        fetch("get_subject_teachers.php?section_id=" + sectionId)

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

// FOR REMOVE CLASS CLOSE IN STUDENT MODAL
let closeModal = () => {

    if (sectionModal) {
        sectionModal.classList.remove("open");
    }

    if (studentModal) {
        studentModal.classList.remove("open");
    }

    if (sec_detailModal) {
        sec_detailModal.classList.remove("open");
    }

    if (subject_TeacherModal) {
        subject_TeacherModal.classList.remove("open");
    }

}

// ---------APPLY FILTERS----------
let searchValue = document.querySelector("#searchInput");
searchValue.addEventListener("keyup", filterTable);

// call function

function filterTable() {

    // for apply filter on student record
    let searchInput = searchValue.value.toLowerCase();
    let classFilter = document.querySelector("#classFilter").value;
    let genderFilter = document.querySelector("#genderFilter").value;


    let rows = document.querySelectorAll("#studentTable tbody tr");

    rows.forEach((row) => {

        let id = row.cells[0].innerText.toLowerCase();
        let name = row.cells[1].innerText.toLowerCase();
        let email = row.cells[2].innerText.toLowerCase();
        let gender = row.cells[4].innerText.trim();
        let studentClass = row.cells[6].innerText.trim();

        let searchMatch = id.includes(searchInput) || name.includes(searchInput) || email.includes(searchInput);
        let genderMatch = genderFilter == "All" || genderFilter == gender;
        let classMatch = classFilter == "All" || studentClass.includes(classFilter);
        console.log(classMatch);
        // console.log(genderMatch);

        if (searchMatch && genderMatch && classMatch) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

function resetFilter() {

    let rows = document.querySelectorAll("#studentTable tbody tr");

    let searchInput = searchValue.value = "";
    let classFilter = document.querySelector("#classFilter").value = "All";
    let genderFilter = document.querySelector("#genderFilter").value = "All";

    rows.forEach(row => {
        row.style.display = "";
    })
}

// ---------To Add Dynamic Content in Card Class----------
document.querySelectorAll(".section-switch-btn").forEach(button => {

    button.addEventListener('click', function () {

        let sectionId = this.dataset.sectionId;
        let classId = this.dataset.classId;

        fetch("get_section_data.php?section_id=" + sectionId + "&class_id=" + classId)

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

// TO SHOW IMAGE BEFORE UPLOAD
let cardPicture = document.querySelector(".card-picture");
let imageInput = document.querySelector("#image-input");
// let image = document.querySelector(".previewImg");

cardPicture.addEventListener('click', function () {

    imageInput.click();

})

//FOR PRIVIEW Image
imageInput.addEventListener('change', function () {

    const file = this.files[0];

    cardPicture.innerHTML = `
    <img src= "${URL.createObjectURL(file)}" class=""> 
     <div class="avatar-overlay">
        <i class="fa-solid fa-camera"></i>
        <span>Change Photo</span>
    </div>
    `

    let remove_photoBtn = document.querySelector(".remove-photo-btn");
    remove_photoBtn.style.display = "flex";

})

// FOR RESET IMAGE
function resetImage() {
    cardPicture.innerHTML = `
    <i class="fa-solid fa-user"></i>

    <div class="avatar-overlay">
        <i class="fa-solid fa-camera"></i>
        <span>Change Photo</span>
    </div>
    `
}

// To make section dropdown dynamically
let selectClass = document.querySelector("#selectClass");

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
document.querySelector('#confirmCancelBtn').addEventListener('click', () => {
    document.querySelector('#custom-confirm-wrapper').classList.remove('open');
    pendingConfirmCallback = null;
});

// CONFIRM OK
document.querySelector('#confirmOkBtn').addEventListener('click', () => {
    document.querySelector('.custom-confirm-box').classList.remove('open');

    if (pendingConfirmCallback) {
        pendingConfirmCallback();
        pendingConfirmCallback = null;
    }
});

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

// FOR DELETE
let deleteBtns = document.querySelectorAll(".delete-btn");

if (deleteBtns.length > 0) {

    deleteBtns.forEach(btn => {

        btn.addEventListener("click", function (e) {

            e.preventDefault(); // link stop ho gaya

            let deleteUrl = this.getAttribute("href");

            openConfirmBox(
                "Delete Student",
                "Are you sure you want to delete this student?",
                true,
                () => {
                    window.location.href = deleteUrl;
                }
            );

        });

    });

}

// Toast Alert Dispatcher System
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
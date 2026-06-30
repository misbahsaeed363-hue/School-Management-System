
// MARK ALL PRESENT

// document
//     .getElementById("markAllPresent")
//     .addEventListener("click", function () {

//         document
//             .querySelectorAll(".attendance-status")
//             .forEach(select => {

//                 select.value = "Present";

//             });

//     });

// DATE UPDATE

document
    .getElementById("attendanceDate")
    .addEventListener("change", function () {

        document
            .getElementById("attendanceDateHidden")
            .value = this.value;

    });

// SEARCH

// document
//     .getElementById("attendanceSearch")
//     .addEventListener("keyup", function () {

//         let value =
//             this.value.toLowerCase();

//         document
//             .querySelectorAll(".student-table-row")
//             .forEach(row => {

//                 let text =
//                     row.innerText.toLowerCase();

//                 row.style.display =
//                     text.includes(value) ?
//                         "" :
//                         "none";

//             });

//     });

// CLASS FILTER

// document
//     .getElementById("classFilter")
//     .addEventListener("change", function() {

//         let selected =
//             this.value;

//         document
//             .querySelectorAll(".student-table-row")
//             .forEach(row => {

//                 if (
//                     selected === "All" ||
//                     row.dataset.class === selected
//                 ) {

//                     row.style.display = "";

//                 } else {

//                     row.style.display = "none";

//                 }

//             });

//     });

let isMarked = false;

// LOAD STUDENTS DATA
function loadStudentsAttendence() {
    let attendenceDate = document.querySelector("#attendanceDate").value;
    let attendenceClass = document.querySelector("#attendence-class").value;
    let attendenceSection = document.querySelector("#desktopSectionFilter").value;
    let markAttendence_btn = document.querySelector("#markAllPresent");
    let saveAttendence = document.querySelector("#saveAttendence");

    fetch("/school_management_system/admin/APIs/load-data-for-attendence.php?date=" + attendenceDate + "&class=" + attendenceClass + "&section=" + attendenceSection)
        .then(response => response.json())
        .then(data => {
            let table = document.querySelector(".table-body");
            let tableContainer = document.querySelector(".student-record");
            let unloadedPlaceholder = document.querySelector("#unloaded-placeholder");
            let forEmptyState = document.querySelector(".empty-state");

            table.innerHTML = "";

            // IF NO RECORD FOUND 
            if (data.length < 1) {
                forEmptyState.style.display = "grid";
                tableContainer.style.display = "none";
                unloadedPlaceholder.style.display = "none";
                return;
            }

            // CHECK IF ALREADY MARKED
            let isMarked = false;
            data.forEach(item => {
                if (item.status) { isMarked = true; }
                if (!item.status) { item.status = "Present"; } // Default Selection is Present
            });

            if (isMarked) {
                showToast("Attendance already marked for this date", "info", "Notice");
            } else {
                showToast("New session", "success", "Success");
            }

            // GENERATE TABLE ROWS (Jo mobile par auto-card banengi)
            data.forEach((item, index) => {
                tableContainer.style.display = "block";
                markAttendence_btn.style.display = "inline-flex";
                saveAttendence.style.display = "inline-flex";
                unloadedPlaceholder.style.display = "none";
                forEmptyState.style.display = "none";

                // Unique ID generation for Radio and Labels
                let p_id = `p_${item.sid}_${index}`;
                let a_id = `a_${item.sid}_${index}`;
                let l_id = `l_${item.sid}_${index}`;
                let lv_id = `lv_${item.sid}_${index}`;

                table.innerHTML += `
                <tr>
    
                    <input type="hidden" name="student_ids[]" value="${item.sid}">
                    
                    <td data-label="ID" style="font-weight: 700; color: #4f46e5;"><div>${item.sid}</div></td>
                    
                    <td data-label="Student">
                        <div class="student-profile">
                            <img src="/school_management_system/${item.images}" class="student-img" alt="avatar">
                            <div>
                                <div class="student-name">${item.name}</div>
                                <div class="student-details">${item.class_id}-${item.section_name}</div>
                            </div>
                        </div>
                    </td>

                     <td data-label="Remarks">
                    <div>
                        <input class="remarks-input" type="text" placeholder="Add optional remarks..." name="remarks[${item.sid}]">
                    </div>
                    </td>
                    
                    <td data-label="Status">
                        <div class="status-selector">
                            <div class="status-option">
                                <input type="radio" name="status[${item.sid}]" id="${p_id}" value="Present" ${item.status === "Present" ? "checked" : ""}>
                                <label for="${p_id}" class="status-btn">P</label>
                            </div>
                            <div class="status-option">
                                <input type="radio" name="status[${item.sid}]" id="${a_id}" value="Absent" ${item.status === "Absent" ? "checked" : ""}>
                                <label for="${a_id}" class="status-btn">A</label>
                            </div>
                            <div class="status-option">
                                <input type="radio" name="status[${item.sid}]" id="${l_id}" value="Late" ${item.status === "Late" ? "checked" : ""}>
                                <label for="${l_id}" class="status-btn">L</label>
                            </div>
                            <div class="status-option">
                                <input type="radio" name="status[${item.sid}]" id="${lv_id}" value="Leave" ${item.status === "Leave" ? "checked" : ""}>
                                <label for="${lv_id}" class="status-btn">Lv</label>
                            </div>
                        </div>
                    </td>
                    
                </tr>
                `;
            });
        });
}

// function loadStudentAttendenceCard(data) {

//     let attendanceCard = document.querySelector(".attendanceCard");

//     attendanceCard.innerHTML = "";

//     data.forEach(item => {

//         if (!item.status) {
//             item.status = "Present";
//         }

//         attendanceCard.innerHTML += `
//     <input type="hidden" name="student_ids[]" value="${item.sid}">

//     <div class="attendance-card">

//         <div class="card-header">
//             <img src="/school_management_system/${item.images}" class="student-img">

//             <div class="student-info">
//                 <h4>${item.name}</h4>
//                 <p>ID: ${item.sid}</p>
//                 <p>${item.class_id}-${item.section_name}</p>
//             </div>
//         </div>

//         <div class="card-body">

//             <div class="card-field">
//                 <label>Status</label>

//                 <div class="status-selector">

//                     <label class="status-option">
//                         <input type="radio"
//                             name="status[${item.sid}]"
//                             value="Present"
//                             ${item.status === "Present" ? "checked" : ""} class="status-selector">
//                         <span class="status-btn">P</span>
//                     </label>

//                     <label class="status-option">
//                         <input type="radio"
//                             name="status[${item.sid}]"
//                             value="Absent"
//                             ${item.status === "Absent" ? "checked" : ""} class="status-selector">
//                         <span class="status-btn">A</span>
//                     </label>

//                     <label class="status-option">
//                         <input type="radio"
//                             name="status[${item.sid}]"
//                             value="Late"
//                             ${item.status === "Late" ? "checked" : ""} class="status-selector">
//                         <span class="status-btn">L</span>
//                     </label>

//                     <label class="status-option">
//                         <input type="radio"
//                             name="status[${item.sid}]"
//                             value="Leave"
//                             ${item.status === "Leave" ? "checked" : ""} class="status-selector">
//                         <span class="status-btn">LV</span>
//                     </label>

//                 </div>

//             </div>

//             <div class="card-field">
//                 <label>Remarks</label>

//                 <input
//                     type="text"
//                     class="remarks-input"
//                     placeholder="Remarks"
//                     name="remarks[${item.sid}]">
//             </div>

//         </div>

//     </div>
//     `;
//     })

// }

// MARK ALL PRESENT
function markAllPresent() {

    let radios = document.querySelectorAll("input[value='Present']");
    radios.forEach(radio => {
        radio.checked = "true";
    })

}

// SAVE ATTENDANCE
if (saveAttendence) {

    saveAttendence.addEventListener('click', function (e) {

        e.preventDefault();

        let attendanceForm = document.querySelector("#attendence-form");

        if (!isMarked) {
            openConfirmBox(
                "Save Attendance",
                "You are about to mark attendance for the first time. Do you want to continue?",
                false,
                () => {
                    attendanceForm.submit();
                }
            );
        } else {
            openConfirmBox(
                "Update Attendance",
                "You are about to mark attendance for the first time. Do you want to continue?",
                false,
                () => {
                    attendanceForm.submit();
                }
            );
        }

    })

}

let desktopAttendanceClass = document.querySelector("#attendence-class");
let mobileAttendanceClass = document.querySelector("#mobile-attendance-class");
let desktopAttendanceSection = document.querySelector("#desktopSectionFilter");
let mobileAttendanceSection = document.querySelector("#mobileAttendanceSection");
let desktopAttendanceDate = document.querySelector("#attendanceDate");
let mobileAttendanceDate = document.querySelector("#attendanceDateMobile");



// CLOSE MOBILE FILTER
// function closeAttendanceFilter() {
//     desktopClassFilter.value = "All";
//     desktopSectionFilter.value = "All";
//     mobileClassFilter.value = "All";
//     mobileSectionFilter.value = "All";
//     if (bottomFilter) {
//         bottomFilter.classList.remove("open");
//     }
//     bottomFilter.classList.remove("open");
// }

document.querySelector(".loadStudentAttendence")?.addEventListener('click', function () {
    desktopAttendanceClass.value = mobileAttendanceClass.value;
    desktopAttendanceSection.value = mobileAttendanceSection.value;
    desktopAttendanceDate.value = mobileAttendanceDate.value;

    loadStudentsAttendence();

    // bottom sheet close
    bottomFilter.classList.remove("open");
})
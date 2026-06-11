
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

// LOAD STUDENTS
function loadStudentsAttendence() {

    let attendenceDate = document.querySelector("#attendanceDate").value;
    let attendenceClass = document.querySelector("#attendence-class").value;
    let attendenceSection = document.querySelector("#desktopSectionFilter").value;
    let markAttendence_btn = document.querySelector("#markAllPresent");
    let saveAttendence = document.querySelector("#saveAttendence");

    fetch("load-data-for-attendence.php?date=" + attendenceDate + "&class=" + attendenceClass + "&section=" + attendenceSection)
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

            // IF RECORD FOUND
            isMarked = false;
            data.forEach(item => {
                if (item.status) {
                    isMarked = true
                }
            })

            if (isMarked) {

                showToast("Attendance already marked for this date",
                    "info",
                    "Notice")

            } else {
                showToast("New session", "success", "Success");
            }

            data.forEach(item => {

                tableContainer.style.display = "flex";
                markAttendence_btn.style.display = "inline-flex";
                saveAttendence.style.display = "inline-flex";
                unloadedPlaceholder.style.display = "none";
                forEmptyState.style.display = "none";

                if (!item.status) {
                    item.status = "Present";
                }

                table.innerHTML += `
                <tr>

                <input type="hidden" name="student_ids[]" value="${item.sid}">

                    <td>${item.sid}</td>
                    <td><img src="${item.images}" class="student-img"></td>
                    <td>${item.name}</td>
                    <td>
                    ${item.class_id}-${item.section_name}
                    </td>

                    <td>
                    <div class="status-selector">
                    <label class="status-option">
                    <input type="radio" name="status[${item.sid}]" value="Present" class="status-selector" ${item.status === "Present" ? "checked" : ""}>
                    <span class="status-btn">P</span>
                    </label>
                     <label class="status-option">
                    <input type="radio" name="status[${item.sid}]" value="Absent" class="status-selector" ${item.status === "Absent" ? "checked" : ""}>
                    <span class="status-btn">A</span>
                    </label>
                     <label class="status-option">
                    <input type="radio" name="status[${item.sid}]" value="Late" class="status-selector" ${item.status === "Late" ? "checked" : ""}>
                    <span class="status-btn">L</span>
                    </label>
                     <label class="status-option">
                    <input type="radio" name="status[${item.sid}]" value="Leave" class="status-selector" ${item.status === "Leave" ? "checked" : ""}>
                    <span class="status-btn">LV</span>
                    </label>
                    </div>
                    </td>

                    <td><input class="remarks-input" type="text" placeholder="Remarks" class="form-control" name="remarks[${item.sid}]"></td>
                </tr>
                `;
            });

        })

}

// MARK ALL PRESENT
function markAllPresent() {

    let radios = document.querySelectorAll("input[value='Present']");
    radios.forEach(radio => {
        radio.checked = "true";
    })

}

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

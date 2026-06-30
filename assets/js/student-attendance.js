document.addEventListener("DOMContentLoaded", () => {

    loadFilters();
    loadAttendance();

});

let allAttendance = [];
let currentPage = 1;



function loadFilters() {

    fetch("/school_management_system/student/APIs/get_student_attendance_filters.php")

        .then(response => response.json())

        .then(data => {

            let monthFilter =
                document.getElementById("monthFilter");

            let yearFilter =
                document.getElementById("yearFilter");

            monthFilter.innerHTML =
                `<option value="All">All Months</option>`;

            yearFilter.innerHTML =
                `<option value="All">All Years</option>`;

            data.months.forEach(month => {

                const monthNames = {
                    "01": "January",
                    "02": "February",
                    "03": "March",
                    "04": "April",
                    "05": "May",
                    "06": "June",
                    "07": "July",
                    "08": "August",
                    "09": "September",
                    "10": "October",
                    "11": "November",
                    "12": "December"
                };

                monthFilter.innerHTML +=
                    `<option value="${month}">
                        ${monthNames[month]}
                    </option>`;
            });

            data.years.forEach(year => {

                yearFilter.innerHTML +=
                    `<option value="${year}">
                        ${year}
                    </option>`;
            });

        });

}



function loadAttendance(page = 1) {

    currentPage = page;

    let month =
        document.getElementById("monthFilter").value;

    let year =
        document.getElementById("yearFilter").value;

    fetch(`/school_management_system/student/APIs/get_student_attendance.php?month=${month}&year=${year}&page=${page}`)

        .then(response => response.json())

        .then(response => {

            let records = response.attendance;

            allAttendance = records;

            renderAttendance(records);

            updateStats(records);

            renderCalendar(records);

            updatePagination(
                response.currentPage,
                response.totalPages
            );

            document.getElementById("paginationInfo")
                .innerText =
                `Showing ${records.length} of ${response.totalRecords} Records`;

        })

        .catch(error => console.log(error));

}



function renderAttendance(records) {

    let tbody =
        document.getElementById("attendanceTableBody");

    let mobileContainer =
        document.getElementById("mobileCardContainer");

    tbody.innerHTML = "";
    mobileContainer.innerHTML = "";

    records.forEach(record => {

        let day = new Date(
            record.attendance_date
        ).toLocaleDateString("en-US", {
            weekday: "long"
        });

        tbody.innerHTML += `
            <tr>
                <td>${record.attendance_date}</td>
                <td>${day}</td>
                <td>${record.status}</td>
                <td>${record.remarks ?? ''}</td>
            </tr>
        `;

        mobileContainer.innerHTML += `
            <div class="glass-card">
                <h4>${record.attendance_date}</h4>
                <p><strong>Day:</strong> ${day}</p>
                <p><strong>Status:</strong> ${record.status}</p>
                <p><strong>Remarks:</strong> ${record.remarks ?? ''}</p>
            </div>
        `;
    });

}



function updateStats(records) {

    let total = records.length;

    let present = records.filter(
        r => r.status.toLowerCase() === "present"
    ).length;

    let absent = records.filter(
        r => r.status.toLowerCase() === "absent"
    ).length;

    let percentage = total > 0
        ? ((present / total) * 100).toFixed(1)
        : 0;

    document.getElementById(
        "statTotalDays"
    ).innerText = total;

    document.getElementById(
        "statPresentDays"
    ).innerText = present;

    document.getElementById(
        "statAbsentDays"
    ).innerText = absent;

    document.getElementById(
        "statPercentage"
    ).innerText = percentage + "%";

    document.getElementById(
        "progressPctText"
    ).innerText = percentage + "%";

    document.getElementById(
        "progressFillBar"
    ).style.width = percentage + "%";

}



function renderCalendar(records) {

    let container =
        document.getElementById("calendarCellsContainer");

    container.innerHTML = "";

    let month =
        document.getElementById("monthFilter").value;



    let year =
        document.getElementById("yearFilter").value;

    // Agar All select ho to current month use karo
    if (month === "All")
        month = new Date().getMonth() + 1;

    if (year === "All")
        year = new Date().getFullYear();

    month = parseInt(month);
    year = parseInt(year);

    // Dynamic Calendar Title
    let monthNames = [
        "January", "February", "March",
        "April", "May", "June",
        "July", "August", "September",
        "October", "November", "December"
    ];

    document.getElementById("calendarMonthTitle").innerText =
        `${monthNames[month - 1]} ${year}`;

    // Month ke total days
    let totalDays =
        new Date(year, month, 0).getDate();

    // Attendance ko object mein convert karo
    let attendanceMap = {};

    records.forEach(record => {

        let day =
            new Date(record.attendance_date).getDate();

        attendanceMap[day] = record.status;
    });

    // To GET ALL DAYS OF MONTH 
    for (let day = 1; day <= totalDays; day++) {

        let date =
            new Date(year, month - 1, day);

        let weekDay =
            date.getDay(); // Sunday = 0

        let status =
            attendanceMap[day];

        let cssClass = "";
        let text = "Not Marked";

        // Sunday Holiday
        if (weekDay === 0) {

            cssClass = "holiday";
            text = "Holiday";
        }

        // Attendance Marked
        else if (status) {

            text = status;

            switch (status.toLowerCase()) {

                case "present":
                    cssClass = "present";
                    break;

                case "absent":
                    cssClass = "absent";
                    break;

                case "late":
                    cssClass = "late";
                    break;

                case "leave":
                    cssClass = "leave";
                    break;
            }
        }

        container.innerHTML += `
            <div class="calendar-cell ${cssClass}">
                <div class="calendar-cell-num">
                    ${day}
                </div>

                <div class="calendar-cell-content">
                    ${text}
                </div>
            </div>
        `;
    }
}


function updatePagination(current, total) {

    let container =
        document.getElementById("paginationContainer");

    container.innerHTML = "";

    if (total <= 1) return;

    if (current > 1) {

        container.innerHTML += `
        <button class="page-btn"
        onclick="loadAttendance(${current - 1})">
            <i class="fa-solid fa-chevron-left"></i>
        </button>`;
    }

    for (let i = 1; i <= total; i++) {

        container.innerHTML += `
        <button
        class="page-btn ${i === current ? 'active' : ''}"
        onclick="loadAttendance(${i})">
            ${i}
        </button>`;
    }

    if (current < total) {

        container.innerHTML += `
        <button class="page-btn"
        onclick="loadAttendance(${current + 1})">
            <i class="fa-solid fa-chevron-right"></i>
        </button>`;
    }

}



function applyFilters() {

    loadAttendance(1);

}



function switchView(type) {

    let table =
        document.getElementById("tableViewContainer");

    let calendar =
        document.getElementById("calendarViewContainer");

    if (type === "table") {

        table.style.display = "block";
        calendar.style.display = "none";

    } else {

        table.style.display = "none";
        calendar.style.display = "block";
    }

}

// FOR ADD CLASS ACTIVE IN VIEW SWITCHER BUTTON
let switchBtns = document.querySelectorAll(".switch-btn");

switchBtns.forEach(switchBtn => {

    switchBtn.addEventListener('click', function () {
        switchBtns.forEach(btn => {
            btn.classList.remove("active");
        })
        this.classList.add("active");
    })

})





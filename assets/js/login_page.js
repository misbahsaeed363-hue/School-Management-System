let emailInput = document.querySelector("#email-input");
let passwordInput = document.querySelector("#password-input");

let adminBtn = document.querySelector("#admin_Btn");
let teacherBtn = document.querySelector("#teacher_Btn");
let studentBtn = document.querySelector("#student_Btn");

// FOR ADMIN
adminBtn.addEventListener('click', function () {
    emailInput.value = "admin@gmail.com";
    passwordInput.value = "admin123";
})

//FOR TEACHER
teacherBtn.addEventListener('click', function () {
    emailInput.value = "fawad12@gmail.com";
    passwordInput.value = "tea7772";
})

// FOR STUDENT
studentBtn.addEventListener('click', function () {
    emailInput.value = "sonia12@gmail.com";
    passwordInput.value = "stu5352";
})

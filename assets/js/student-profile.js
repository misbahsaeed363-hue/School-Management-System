// FOR ADD DYNAMIC CONTENT IN STUDENT PROFILE
document.addEventListener("DOMContentLoaded", () => {
    loadStudentProfile();
});

function loadStudentProfile() {

    fetch("/school_management_system/student/APIs/get_student_profile.php")
        .then(response => response.json())
        .then(data => {

            console.log(data);
            console.log(data.student);
            // =========================
            // STUDENT Information
            // =========================

            if (data) {

                document.getElementById("name").value =
                    data.name ?? "";

                document.getElementById("email").value =
                    data.email ?? "";

                document.getElementById("phone").value =
                    data.phone ?? "";

                document.getElementById("age").value =
                    data.age ?? "";

                document.getElementById("gender").value =
                    data.gender ?? "";

                document.getElementById("address").value =
                    data.address ?? "";

                document.getElementById("status").value =
                    data.status ?? "";

                // FOR SIDECARD

                document.getElementById("sideCardName").textContent =
                    data.name ?? "";

                document.getElementById("sideCardSid").textContent =
                    data.sid ?? "";

                document.getElementById("sideCardEmail").textContent =
                    data.email ?? "";

                document.getElementById("sideCardClass").textContent =
                    data.class_name ?? "";

                document.getElementById("sideCardSection").textContent =
                    data.section_name ?? "";

                // for image

                if (
                    data.images &&
                    document.getElementById("profileImgDisplay")
                ) {
                    document.getElementById("profileImgDisplay").src =
                        "/school_management_system/" +
                        data.images;
                }

                // FOR ACAEMIC OVERVIEW
                document.querySelector("#overviewClass").textContent =
                    data.class_name ?? "";

                document.querySelector("#overviewSection").textContent =
                    data.section_name ?? "";

                document.querySelector("#overviewStatus").textContent =
                    data.status ?? "";



            }

        })
}

// FOR ENABLE EDIT MODE
function enableEditMode() {

    // Editable fields enable karo

    document.getElementById("phone").disabled = false;
    document.getElementById("address").disabled = false;

    // Image upload enable

    document.getElementById("profile-image-input").disabled = false;

    // Buttons show/hide

    document.getElementById("editProfileBtn").style.display = "none";

    document.getElementById("profileFormActions").style.display = "flex";

    document.getElementById("removePhotoBtn").style.display = "flex";
}

function triggerImageUpload() {

    if (!document.getElementById("profile-image-input").disabled) {

        document
            .getElementById("profile-image-input")
            .click();
    }
}

// PREVIEW PROFILE IMAGE BEFORE UPLOAD
function previewProfileImage(input) {

    if (input.files && input.files[0]) {

        const file = input.files[0];

        let cardpicture = document.querySelector(".card-picture.profile")

        cardpicture.innerHTML = `
            <img src="${URL.createObjectURL(file)}">
            <div class="avatar-overlay">
                <i class="fa-solid fa-camera"></i>
                <span>Change Photo</span>
            </div>
        `;

    }
}

function cancelEditMode() {

    // Inputs disable 

    document.getElementById("phone").disabled = true;
    document.getElementById("address").disabled = true;

    // Image input disable

    document.getElementById("profile-image-input").disabled = true;

    // Buttons show/hide

    document.getElementById("editProfileBtn").style.display = "flex";

    document.getElementById("profileFormActions").style.display = "none";

    document.getElementById("removePhotoBtn").style.display = "none";

    // load profile

    loadStudentProfile();
}

function saveProfileData(e) {

    e.preventDefault();

    openConfirmBox(
        "Update Profile",
        "Are you sure you want to save these changes?",
        false,
        () => {
            let formData = new FormData();


            formData.append(
                "phone",
                document.getElementById("phone").value
            );

            formData.append(
                "address",
                document.getElementById("address").value
            );

            const imageInput =
                document.getElementById("profile-image-input");

            if (imageInput.files.length > 0) {

                formData.append(
                    "profile_image",
                    imageInput.files[0]
                );
            }

            fetch("/school_management_system/student/APIs/update_student_profile.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())

                .then(data => {

                    if (data.success) {

                        showToast(
                            data.message,
                            "success",
                            "Success"
                        );

                        loadStudentProfile();

                        cancelEditMode();

                    } else {

                        showToast(
                            data.message,
                            "error",
                            "Error"
                        );
                    }
                })

        })

}


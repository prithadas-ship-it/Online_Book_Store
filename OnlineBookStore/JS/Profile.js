document.addEventListener("DOMContentLoaded", function () {
    const profileForm = document.getElementById("profileForm");
    const fileInput = document.getElementById("profile_pic");
    const previewImg = document.getElementById("preview-img");
    const errorBox = document.getElementById("js-error-box");

    if (fileInput) {
        fileInput.addEventListener("change", function () {
            const file = this.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    showError("File size must be less than 2MB!");
                    this.value = "";
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function (e) {
                    if (previewImg) previewImg.setAttribute("src", e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    }

    if (profileForm) {
        profileForm.addEventListener("submit", function (e) {
            e.preventDefault(); 

            const name = document.getElementById("name").value.trim();
            const email = document.getElementById("email").value.trim();
            const currPass = document.getElementById("curr_pass").value;
            const newPass = document.getElementById("new_pass").value;

            if (name === "" || email === "") {
                showError("Name and Email fields cannot be empty.");
                return;
            }

            if (newPass !== "") {
                if (currPass === "") {
                    showError("Please enter your current password to set a new password.");
                    return;
                }
                if (newPass.length < 8) {
                    showError("New password must be at least 8 characters long.");
                    return;
                }
            }

            let formData = new FormData(profileForm);
            formData.append("update_profile", "1");

            fetch("../Control/Profilecontrol.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    hideError();
                    alert(data.message);
                } else {
                    showError(data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                showError("Something went wrong! Please try again.");
            });
        });
    }

    function showError(message) {
        if (errorBox) {
            errorBox.textContent = message;
            errorBox.style.display = "block";
            errorBox.style.color = "red";
        } else {
            alert(message);
        }
    }

    function hideError() {
        if (errorBox) {
            errorBox.style.display = "none";
        }
    }
});
document.addEventListener("DOMContentLoaded", function () {
    const registerForm = document.getElementById("registerForm");

    if (registerForm) {
        registerForm.addEventListener("submit", function (event) {
            event.preventDefault(); 

            if (!validateForm()) {
                return;
            }

            let formData = new FormData(registerForm);
            formData.append("mysubmit", "true"); 

            fetch("../Control/RegisterControl.php", {
                 method: "POST",
                 body: formData
            })
            .then(async response => {
                const text = await response.text(); 
                try {
                     return JSON.parse(text); 
                } catch (err) {
                    console.error("Server Output (Not JSON):", text); 
                    throw new Error("Server did not return valid JSON");
                }
            })
            .then(data => {
                if (data.status === "success") {
                    alert(data.message);
                    window.location.href = "../View/Login.php";
                } else {
                        alert(data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Something went wrong! Check console for details.");
            });
        });
    }
});

function validateForm() {
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();
    let confirmPassword = document.getElementById("confirm_password").value.trim();
    let address = document.getElementById("address").value.trim();
    let phone = document.getElementById("phone").value.trim();
    let role = document.getElementById("role").value;

    if (name === "") {
        alert("Please enter your full name!");
        return false;
    }

    if (email === "") {
        alert("Please enter your email address!");
        return false;
    }

    if (password === "") {
        alert("Please enter a password!");
        return false;
    }

    if (password.length < 8) {
        alert("Password must be at least 8 characters long!");
        return false;
    }

    if (confirmPassword === "") {
        alert("Please confirm your password!");
        return false;
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match!");
        return false;
    }

    if (address === "") {
        alert("Please enter your address!");
        return false;
    }

    if (phone === "") {
        alert("Please enter your phone number!");
        return false;
    }

    if (role === "") {
        alert("Please select a role (Customer or Admin)!");
        return false;
    }

    return true;
}
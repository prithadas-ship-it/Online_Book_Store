document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("loginForm"); 

    if (loginForm) {
        loginForm.addEventListener("submit", function (e) {
            e.preventDefault(); 

            if (!validateLoginForm()) {
                return;
            }

            let formData = new FormData(loginForm);

            fetch("../Control/Logincontrol.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    window.location.href = data.redirect; 
                } else {
                    let passwordError = document.getElementById("passwordError");
                    if (passwordError) {
                        passwordError.innerText = data.message;
                    } else {
                        alert(data.message);
                    }
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Something went wrong! Please try again.");
            });
        });
    }
});

function validateLoginForm() {
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value;
    let emailError = document.getElementById("emailError");
    let passwordError = document.getElementById("passwordError");
    
    let isValid = true;

    if (emailError) emailError.innerText = "";
    if (passwordError) passwordError.innerText = "";

    if (email === "") {
        if (emailError) emailError.innerText = "Email is required.";
        isValid = false;
    } else {
        let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailPattern.test(email)) {
            if (emailError) emailError.innerText = "Please enter a valid email address.";
            isValid = false;
        }
    }

    if (password === "") {
        if (passwordError) passwordError.innerText = "Password is required.";
        isValid = false;
    }

    return isValid;
}
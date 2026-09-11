document.addEventListener("DOMContentLoaded", function () {

    const prevBtn = document.querySelector(".prev-btn");
    const nextBtn = document.querySelector(".next-btn");
    
    if(prevBtn && nextBtn) {
    }
});


function subscribeNewsletter(event) {
    event.preventDefault(); 

    const emailInput = document.getElementById("newsletterEmail");
    const email = emailInput ? emailInput.value.trim() : "";

    if (!email) {
        alert("Please enter a valid email address.");
        return false;
    }

    const formData = new FormData();
    formData.append("action", "subscribe_newsletter");
    formData.append("email", email);

   
    fetch("../Control/Homecontrol.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert(data.message);
            emailInput.value = ""; 
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Something went wrong! Please try again later.");
    });

    return false;
}
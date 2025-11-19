// Select the first element with class "loginButton"
const loginButton = document.querySelector(".loginButton");

loginButton.addEventListener("click", (e) => {
    e.preventDefault();
    // Get input values
    const email = document.querySelector('input[name="email"]').value.trim();
    const password = document.querySelector('input[name="password"]').value.trim();

    if (!email || !password) {
        showToast("Please fill in both email and password.", "error");
        return;
    }

    // Axios POST request
    axios.post("/login", { email, password })
        .then(response => {
            console.log("Login successful:", response.data);
            // window.location.href = "/dashboard";
        })
        .catch(error => {
            if (error.response) {
                console.error("Login failed:", error.response.data);
                showToast(error.response.data.message || "Login failed", "error");
            } else {
                console.error("Error:", error.message);
            }
        });
});


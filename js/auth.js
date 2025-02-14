function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

function updateMode(newMode) {
    // Update URL without reloading the page
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('mode', newMode);
    window.history.pushState({}, '', '?' + urlParams.toString());
    // Refresh the page after updating the URL
    window.location.reload();
}

function updateUI(mode) {
    const title = document.querySelector(".title");
    const titlechange = document.querySelector(".titlechange");
    const change = document.querySelector("#change");
    const changebutton = document.querySelector("#changebutton");

    if (mode === "signup") {
        title.textContent = "Signup";
        titlechange.textContent = "Signup";
        changebutton.textContent = "Login";
        change.textContent = "Already have an account?✨";
    } else {
        title.textContent = "Login";
        titlechange.textContent = "Login";
        changebutton.textContent = "Signup";
        change.textContent = "Don't have an account?🔑";
    }
}

// Get the initial mode from URL
const mode = getQueryParam("mode") || "login"; // Default to login
updateUI(mode);

// Set up the event listener for the toggle button
const changebutton = document.querySelector("#changebutton");
changebutton.addEventListener("click", function() {
    const currentMode = getQueryParam("mode") || "login";
    const newMode = currentMode === "signup" ? "login" : "signup";
    updateMode(newMode);
});

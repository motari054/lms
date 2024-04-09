 function redirectTo(url) {
    window.location.href = url;
}

// Event listener for the button click
document.getElementById("redirectBtn").addEventListener("click", function() {
    // Replace 'YOUR_URL_HERE' with the URL you want to redirect to
    redirectTo('http://localhost/simpleloansystem/users/index.php?page=dashboard');
});
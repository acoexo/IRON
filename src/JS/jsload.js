document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("header").style.display = "flex";
    document.getElementById("main").style.display="none";
    window.addEventListener("load", function() {
        setTimeout(function() {
            document.getElementById("header").style.display = "none";
            document.getElementById("main").style.display = "flex";
        }, 2000);
    });
});
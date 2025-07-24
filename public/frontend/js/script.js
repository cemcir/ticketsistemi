let lastScrollY = window.scrollY;

window.addEventListener("scroll", () => {
    const header = document.querySelector(".header");

    if (window.scrollY > lastScrollY) {
        // Sayfa aşağı kaydırılıyor
        header.classList.add("hide");
    } else {
        // Sayfa yukarı kaydırılıyor
        header.classList.remove("hide");
    }

    lastScrollY = window.scrollY;
});

document.addEventListener("DOMContentLoaded", function() {
    const menuIcon = document.getElementById("menu-icon");
    const navbar = document.querySelector(".navbar");

    menuIcon.onclick = function() {
        navbar.classList.toggle("active"); // Toggle menu open/close
    };

    // Hide the menu when scrolling
    window.addEventListener("scroll", function() {
        if (navbar.classList.contains("active")) {
            navbar.classList.remove("active"); // Close the menu on scroll
        }
    });
});

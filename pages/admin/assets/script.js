function toggleMenu() {
    var menu = document.getElementById("user-menu");
    if (menu.style.display === "none") {
        menu.style.display = "block";
    } else {
        menu.style.display = "none";
    }
}
function toggleMobileMenu() {
    var menuOpenIcon = document.getElementById("menu-open-icon");
    var menuCloseIcon = document.getElementById("menu-close-icon");

    menuOpenIcon.classList.toggle("hidden");
    menuCloseIcon.classList.toggle("hidden");

    var mobileMenu = document.getElementById("mobile-menu");
    mobileMenu.classList.toggle("hidden");
    mobileMenu.setAttribute("aria-expanded", mobileMenu.classList.contains("hidden") ? "false" : "true");
}
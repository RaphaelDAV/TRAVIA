function toggleMenu() {
    const navLinks = document.querySelector('.nav-links');
    navLinks.classList.toggle('show');

    if (navLinks.classList.contains('show')) {
        document.addEventListener('click', closeMenuOnClickOutside);
    } else {
        document.removeEventListener('click', closeMenuOnClickOutside);
    }
}

function closeMenuOnClickOutside(event) {
    const navLinks = document.querySelector('.nav-links');
    const burgerMenu = document.querySelector('.burger-menu');

    if (!navLinks.contains(event.target) && !burgerMenu.contains(event.target)) {
        navLinks.classList.remove('show');
        document.removeEventListener('click', closeMenuOnClickOutside);
    }
}
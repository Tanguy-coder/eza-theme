document.addEventListener('DOMContentLoaded', function() {
    console.log('Website loaded successfully');

    let nav_mobile = document.querySelector(".nav-mobile");
    let menu = document.querySelector('.menu');
    let close_menu_button = document.querySelector('.close-menu');

    if (menu) {
        menu.addEventListener('click', function() {
            nav_mobile.classList.add("nav-mobile-apparition");
        });
    }

    if (close_menu_button) {
        close_menu_button.addEventListener('click', function() {
            nav_mobile.classList.remove("nav-mobile-apparition");
        });
    }

    // Ajout de la classe 'scrolled' au header lors du défilement
    window.addEventListener('scroll', function() {
        let header = document.querySelector('header');
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
});
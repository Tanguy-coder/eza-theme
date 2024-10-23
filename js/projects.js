document.addEventListener('DOMContentLoaded', function () {
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 1,
        spaceBetween: 1,
        loop: true, // Permet au slider de recommencer en boucle
        autoplay: {
            delay: 5000, // Temps de changement : 5000ms = 5s
            disableOnInteraction: false, // Continue même si on interagit avec le slider
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
});

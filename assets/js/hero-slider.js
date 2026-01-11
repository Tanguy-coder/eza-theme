/**
 * Hero Slider Initialization (Swiper.js)
 */
document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector('.hero-slider')) {
        new Swiper('.hero-slider', {
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            speed: 1500, // Durée de la transition douce
        });
    }
});

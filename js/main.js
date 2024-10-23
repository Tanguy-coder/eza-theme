document.addEventListener('DOMContentLoaded', function () {
    // Initialisation du slider Swiper
    var swiper = new Swiper('.swiper-container', {
        loop: true, // Boucle infinie
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 3000, // Durée avant de passer à la diapositive suivante
            disableOnInteraction: false,
        },
    });
});
alert('zggzg')
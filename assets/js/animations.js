/**
 * Scroll Animations using Intersection Observer
 */
document.addEventListener('DOMContentLoaded', function () {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('reveal-active');
                observer.unobserve(entry.target); // Animé une seule fois
            }
        });
    }, observerOptions);

    // Cibler les éléments à animer
    const animateElements = document.querySelectorAll('.project-item, .partners h2, .partners-logos a, .hero-slider');

    animateElements.forEach(el => {
        el.classList.add('reveal');
        observer.observe(el);
    });
});

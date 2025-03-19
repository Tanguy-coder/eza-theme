document.addEventListener('DOMContentLoaded', function () {
    console.log('Website loaded successfully');

    let nav_mobile = document.querySelector(".nav-mobile");
    let menu = document.querySelector('.menu');
    let close_menu_button = document.querySelector('.close-menu');

    if (menu) {
        menu.addEventListener('click', function () {
            nav_mobile.classList.add("nav-mobile-apparition");
        });
    }

    if (close_menu_button) {
        close_menu_button.addEventListener('click', function () {
            nav_mobile.classList.remove("nav-mobile-apparition");
        });
    }

    // Ajout de la classe 'scrolled' au header lors du défilement
    window.addEventListener('scroll', function () {
        let header = document.querySelector('header');
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Ajouter le lecteur YouTube via l'API YouTube
    let player;

    function onYouTubeIframeAPIReady() {
        const iframe = document.querySelector('.wp-block-embed__wrapper iframe');
        if (iframe) {
            player = new YT.Player(iframe, {
                events: {
                    'onReady': onPlayerReady,
                }
            });
        }
    }

    function onPlayerReady(event) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    event.target.playVideo(); // Lecture automatique
                } else {
                    event.target.pauseVideo(); // Pause automatique
                }
            });
        });

        const iframe = document.querySelector('.wp-block-embed__wrapper iframe');
        if (iframe) {
            observer.observe(iframe);
        }
    }

    // Initialiser l'API YouTube
    window.onYouTubeIframeAPIReady = onYouTubeIframeAPIReady;
});


    // Fonction pour activer le plein écran
function requestFullScreen(element) {
    if (element.requestFullscreen) {
    element.requestFullscreen();
    } else if (element.mozRequestFullScreen) { // Firefox
        element.mozRequestFullScreen();
    } else if (element.webkitRequestFullscreen) { // Chrome, Safari, Opera
        element.webkitRequestFullscreen();
    } else if (element.msRequestFullscreen) { // IE/Edge
        element.msRequestFullscreen();
    }
}

    // API YouTube pour contrôler la vidéo
    var player;
    function onYouTubeIframeAPIReady() {
    player = new YT.Player('video-iframe', {
        events: {
            'onStateChange': onPlayerStateChange
        }
    });
}

    // Passer la vidéo en plein écran quand on appuie sur "Play"
    function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.PLAYING) {
    var iframe = document.getElementById('video-iframe');
    requestFullScreen(iframe); // Appelle la fonction pour passer en plein écran
}
}

    // Charger l'API YouTube
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var typed = new Typed("#typed", {
    strings: ["une agence d'innovation.", "Un phare de la modernité.","Avant-gardiste de l'architecture contemporaine."],
    typeSpeed: 60,
    backSpeed:50,
    backDelay:1000,
    loop: true,
    showCursor: false
});



// Example placeholder for future interactivity
document.addEventListener('DOMContentLoaded', function () {
    console.log('Website loaded successfully');
});

let nav_mobile = document.querySelector(".nav-mobile")
let menu = document.querySelector('.menu')
let close_menu_button = document.querySelector('.close-menu')

menu.addEventListener('click', function(){
    nav_mobile.classList.toggle("nav-mobile-apparition")
})


close_menu_button.addEventListener('click', function (){
    nav_mobile.classList.toggle("nav-mobile-apparition")

})
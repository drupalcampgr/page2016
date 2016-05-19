var mainMenu = document.getElementById('block-drupalcampathens2016-main-menu');

function onScrool(){
    if(window.scrollY >= 500 && !mainMenu.classList.contains("is_fixed")){
        mainMenu.className +=" is_fixed";
    }
    if(window.scrollY < 500 && mainMenu.classList.contains("is_fixed")){
        mainMenu.classList.remove("is_fixed");
    }
}

window.addEventListener('scroll', onScrool);
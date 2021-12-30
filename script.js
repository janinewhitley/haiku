let hearts = document.querySelectorAll(".heart");

hearts.forEach(heart => {
    heart.addEventListener('click', (e) => {
        e.preventDefault();
        heart.classList.add('liked');
    });
});

let showHaikus = document.getElementById("showHaikus");
let showLikes = document.getElementById("showLikes");

let userHaikus = document.getElementById("userHaikus");
let likedHaikus = document.getElementById("likedHaikus");

showHaikus.addEventListener('click', () => {
    showLikes.style.fontWeight = "600";
    showHaikus.style.fontWeight = "400";
    showHaikus.style.pointerEvents = "none"
    showLikes.style.pointerEvents = "auto";
    likedHaikus.style.display = "none";
    userHaikus.style.display = "flex";
});

showLikes.addEventListener('click', () => {
    showHaikus.style.fontWeight = "600";
    showLikes.style.fontWeight = "400";
    showHaikus.style.pointerEvents = "auto";
    showLikes.style.pointerEvents = "none";
    userHaikus.style.display = "none";
    likedHaikus.style.display = "flex";
});

let profile = document.querySelector('.profile');
let menu = document.querySelector('.logout');

profile.addEventListener('click', () => {
   menu.style.display = 'flex'; 
});
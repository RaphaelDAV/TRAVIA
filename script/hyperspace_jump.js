import "./space.js";

const playButton = document.getElementById('submitButton');
const video = document.getElementById('background-video');
const form = document.querySelector('form'); // Sélectionnez le formulaire

// On click
playButton.addEventListener('click', function(event) {
    event.preventDefault();

    video.style.display = 'block';

    requestAnimationFrame(() => {
        video.style.opacity = 1;
    });

    video.play().then(() => {
        console.log("Vidéo en cours de lecture");
    }).catch((error) => {
        console.error("Erreur de lecture vidéo : ", error);
    });

    playButton.style.display = 'none';

    // Fade animation
    video.addEventListener('timeupdate', function() {
        const fadeStartTime = video.duration - 1;
        if (video.currentTime >= fadeStartTime && video.style.opacity === '1') {
            video.style.opacity = 0;

            setTimeout(() => {
                form.submit();
            }, 200);
        }
    });
});

import './space';

const playButton = document.getElementById('submitButton');
const video = document.getElementById('background-video');

// On click
playButton.addEventListener('click', function() {
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
});

// Fade animation
video.addEventListener('timeupdate', function() {
    const fadeStartTime = video.duration - 1;
    if (video.currentTime >= fadeStartTime && video.style.opacity === '1') {
        video.style.opacity = 0;

        setTimeout(() => {
            window.location.href = '../src/map.php';
        }, 200);
    }
})

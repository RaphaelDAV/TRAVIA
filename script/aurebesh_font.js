document.addEventListener('DOMContentLoaded', function() {
    const auLink = document.getElementById('au');
    const enLink = document.getElementById('en');

    // Ajouter l'événement sur le lien "AU"
    auLink.addEventListener('click', function(event) {
        event.preventDefault();
        document.documentElement.classList.add('au-font');
        console.log("Police changée");
    });

    enLink.addEventListener('click', function(event) {
        event.preventDefault();
        document.documentElement.classList.remove('au-font');
    });
});
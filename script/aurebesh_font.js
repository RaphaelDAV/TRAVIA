document.addEventListener('DOMContentLoaded', function() {
    const auLink = document.getElementById('au');
    const enLink = document.getElementById('en');

    auLink.addEventListener('click', function(event) {
        event.preventDefault();
        document.documentElement.classList.add('au-font');
        console.log("Police changed");
    });

    enLink.addEventListener('click', function(event) {
        event.preventDefault();
        document.documentElement.classList.remove('au-font');
    });
});
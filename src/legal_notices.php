<head>
    <meta charset="UTF-8">
    <title>Legal Notices</title>
    <link rel="stylesheet" type="text/css" href="../css/legal_conditions.css" />
    <link rel="stylesheet" type="text/css" href="../css/header_footer.css" />
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/star-wars" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div id="header-container"></div>
<script src="../script/nav_bar.js" defer></script>
<script>
    fetch('header.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('header-container').innerHTML = data;
        })
        .catch(error => {
            console.error('Erreur lors du chargement du header:', error);
        });
</script>

<section class="container">
    <div class="credits">
        <div class="headings">
            <h1>legal notices</h1>
        </div>
        <h2>1. Site Publisher</h2>
        <p>This site was developed as part of an educational project at Université Gustave Eiffel, IUT de Champs-sur-Marne, under the supervision of Thomas Fressin.</p>
        <p><strong>Contact:</strong> <a href="mailto:thomas.fressin@univ-eiffel.fr">thomas.fressin@univ-eiffel.fr</a></p>

        <h2>2. Hosting</h2>
        <p>The site is hosted on the infrastructure of Gustave Eiffel Universityfor educational purposes only.</p>
        <ul>
            <li><strong>Host:</strong> Gustave Eiffel University</li>
            <li><strong>Address:</strong> Champs-sur-Marne, 77420 Marne-la-Vallée, France</li>
        </ul>

        <h2>3. Purpose of the Site</h2>
        <p>The "Travia Tour" site is an educational project aimed at developing a web application for booking tickets for fictional interplanetary travel. It follows modern web development principles (HTML, CSS, PHP, MySQL). No commercial use is made of this site.</p>

        <h2>4. Personal Data</h2>
        <p>No real personal data is collected or processed for this project. Any data entered or simulated is used solely for educational and testing purposes.</p>
        <p>RGPD compliance rules are applied according to the <a href="https://lincnil.github.io/Guide-RGPD-du-developpeur/" target="_blank">Developer's RGPD Guide</a> published by the CNIL.</p>

        <h2>5. Intellectual Property</h2>
        <p>All site content, including texts, images, and source code, is protected under French and international intellectual property laws. The use of external resources (fonts, images, libraries like Leaflet) respects copyrights and associated licenses.</p>

        <h2>6. Liability</h2>
        <p>Gustave Eiffel University and its students disclaim all responsibility for any misuse or incorrect interpretation of the data on this site, which is provided "as is" in a purely educational context.</p>

        <h2>7. Deletion Date</h2>
        <p>The site will be deleted before July 2025, in accordance with Gustave Eiffel's University guidelines.</p>
    </div>
</section>

<div id="footer-container"></div>
<script>
    window.onload = function() {
        fetch('footer.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('footer-container').innerHTML = data;
            })
            .catch(error => {
                console.error('Error while loading footer:', error);
            });
    }
</script>

<script>
    window.addEventListener('scroll', function() {
        let scrollY = window.scrollY;
        let scrollHeight = document.body.scrollHeight - window.innerHeight;
        let scrollPercent = scrollY / scrollHeight;

        let scale = 1 - scrollPercent;
        let translateY = (scrollHeight - scrollY) / 10;
        let rotateX = 60;

        document.querySelector('.credits').style.transform = `perspective(1200px) rotateX(${rotateX}deg) translateY(${translateY}px) scale(${scale})`;
    });
</script>





</body>
</html>

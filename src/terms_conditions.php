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
            <h1>Terms of Use</h1>
        </div>
        <h2>1. Introduction</h2>
        <p>Welcome to the "Travia Tour" website. These Terms of Use govern your access to and use of this website, created as part of an educational project at Université Gustave Eiffel. By accessing or using the site, you agree to comply with these Terms. If you do not agree, please refrain from using the site.</p>

        <h2>2. Purpose of the Site</h2>
        <p>The "Travia Tour" website is a fictional educational project designed for demonstrating the functionalities of a web application for booking interplanetary travel tickets. The content, including all data, images, and text, is purely for learning and testing purposes. This site has no commercial intent and does not represent real services.</p>

        <h2>3. Site Publisher</h2>
        <ul>
            <li><p><b>Publisher: Gustave Eiffel University, IUT de Champs-sur-Marne</b></p></li>
            <li><p><b>Supervisor: </b>Thomas Fressin</p></li>
            <li><b>Contact: </b><a href="contact.php">Contact</a></li>
        </ul>

        <h2>4. Hosting Information</h2>
        <p>The website is hosted on the infrastructure of Université Gustave Eiffel for educational purposes only.</p>

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

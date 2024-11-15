<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="../css/contact.css">
    <link rel="stylesheet" href="../css/header_footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/star-wars" rel="stylesheet">
</head>
<body>
<!-- Include header with JS-->
<div id="header-container"></div>
<script>
    fetch('header.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('header-container').innerHTML = data;
        })
        .catch(error => {
            console.error('Erreur lors du chargement du header:', error);
        });
</script>



<section class="contact">
    <div class="left-contact">
        <div class="left-flex">
            <h2>CONTACT</h2>
            <h2 id="us">US</h2>

            <p>For any enquires, or just say hello, get in touch and contact us
                <br><br>
                Our mail: travia.contact@gmail.com
            </p>
        </div>
        <div class="left-flex2">
            <form action="contact_form.php" method="post">
                <div class="form-group">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" name="first_name" required>
                </div>
                <div class="form-group">
                    <label for="last-name">Last Name</label>
                    <input type="text" id="last-name" name="last_name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                <button type="submit">Submit</button>
            </form>

        </div>
    </div>

    <div class="right-contact"></div>
</section>


<!-- Include footer with JS-->
<div id="footer-container"></div>
<script>
    window.onload = function() {
        fetch('footer.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('footer-container').innerHTML = data;

                const auLink = document.getElementById('au');
                const enLink = document.getElementById('en');

                if (auLink && enLink) {
                    auLink.addEventListener('click', function(event) {
                        event.preventDefault();
                        document.documentElement.classList.add('au-font');
                        console.log("Police Aurebesh appliquée");
                    });

                    enLink.addEventListener('click', function(event) {
                        event.preventDefault();
                        document.documentElement.classList.remove('au-font');
                        console.log("Police Aurebesh retirée");
                    });
                }
            })
            .catch(error => {
                console.error('Error while loading footer:', error);
            });
    }
</script>

</body>
</html>


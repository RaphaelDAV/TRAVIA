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
    <!--<base href="http://localhost:63342/TRAVIA/">-->
    <base href="/~raphael.daviot/TRAVIA/">
</head>
<body>
<!-- Include header with JS-->
<div id="header-container"></div>
<script src="../script/nav_bar.js" defer></script>
<script>
    fetch('src/header.php')
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
            <div id="message-container" style="display: none; margin-top: 20px;"></div>
            <form action="php/contact_form.php" method="post">
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

<script>
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    const error = urlParams.get('error');
    const messageContainer = document.getElementById('message-container');

    if (success) {
        messageContainer.style.display = 'block';
        messageContainer.style.color = '#E7C863';
        messageContainer.style.fontFamily ='Josefin Sans'
        messageContainer.style.fontSize = 'calc(10px + 0.5vw)';
        messageContainer.textContent = 'Your message has been sent successfully. Thank you for contacting us!';
    } else if (error) {
        messageContainer.style.display = 'block';
        messageContainer.style.color = 'red';
        messageContainer.style.fontFamily ='Josefin Sans'
        messageContainer.textContent = 'An error occurred while sending your message. Please try again.';
    }
</script>


<!-- Include footer with JS-->
<div id="footer-container"></div>
<script>
    window.onload = function() {
        fetch('../src/footer.php')
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


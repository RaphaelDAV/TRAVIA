<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="../css/account.css">
    <link rel="stylesheet" href="../css/header_footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/star-wars" rel="stylesheet">
</head>
<body>
<div id="header-container"></div>
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

<section class="banner">
    <div class="profile">
        <img src="../assets/account/palpatine.jpg" alt="Profile" class="profile-image">
    </div>
</section>

<section class="form-section">
    <form>
        <div class="form-group">
            <label>First name</label>
            <input type="text" placeholder="First name" value="Palpatine">
        </div>
        <div class="form-group">
            <label>Last name</label>
            <input type="text" placeholder="Last name" value="Sheev">
        </div>
        <div class="form-group">
            <label>Date of birth</label>
            <input type="date" placeholder="Date of birth" value="2006-11-13">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" placeholder="Email" value="palpatine.kawai@gmail.com">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" placeholder="Password" value="palpat123">
        </div>
        <div class="form-group">
            <label>Items in your cart</label>
            <input type="text" placeholder="Items in your cart" value="2" readonly>
        </div>
        <div class="form-group">
            <label>Planet</label>
            <input type="text" placeholder="Planet" value="Coruscant">
        </div>
        <div class="form-group">
            <label style="color: rgba(0,0,0,0)"> Submit Button</label>
            <input type="submit" value="Submit">
        </div>
    </form>
</section>


<!-- Include footer with JS-->
<div id="footer-container"></div>
<script>
    window.onload = function() {
        fetch('src/footer.php')
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

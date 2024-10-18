<?php
require 'conf.php';

// Préparer et exécuter la requête
$recupName = $pdo->prepare('SELECT name FROM planets');
$recupName->execute();

// Récupérer les résultats sous forme de tableau
$planetNames = $recupName->fetchAll(PDO::FETCH_COLUMN);

// Encoder les noms des planètes en JSON pour les utiliser dans JavaScript
$planetNamesJson = json_encode($planetNames);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travia</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>
    <script>
        $( function() {
            // Récupérer les noms des planètes depuis PHP encodé en JSON
            var availableTags = <?php echo $planetNamesJson; ?>;

            $( "#departure" ).autocomplete({
                source: function(request, response) {
                    var term = $.ui.autocomplete.escapeRegex(request.term);
                    var matcher = new RegExp("^" + term, "i");  // Expression régulière pour correspondre au début du mot
                    var filteredTags = $.grep(availableTags, function(item){
                        return matcher.test(item);
                    });
                    response(filteredTags);  // Retourner seulement les correspondances
                },
                minLength: 2 // Lancer l'autocomplétion seulement après 2 caractères
            });
        });
    </script>

</head>
<body>
<?php
require '../includes/header.inc.php';
?>
<div class="container-form">
    <form method="get" action="results.php" class="search">
        <label for="departure">Departure</label>
        <input id="departure" name="departure" type="text" placeholder="Coruscant" required>
        <label for="arrival">Arrival</label>
        <input id="arrival" name="arrival" type="text" placeholder="Planet of arrival" required>
        <div class="search-button">
            <button name="submit-map" type="submit">see on map</button>
            <button name="submit-ticket" type="submit">tickets</button>
        </div>

    </form>
</div>
<?php
require '../includes/footer.inc.php';
?>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Météo au Maroc</title>
    <link rel="stylesheet" href="sty.css">
</head>
<body>
    <h1>☀ Météo au Maroc</h1>
    <form method="post">
        <label for="city">Choisir une ville :</label>
        <select name="city" id="city">
            <?php
            $villes = ["Casablanca", "Rabat", "Oujda", "Marrakesh", "Tangier", "Fez", "Agadir", "Meknes"];
            foreach ($villes as $ville) {
                $selected = (isset($_POST['city']) && $_POST['city'] == $ville) ? 'selected' : '';
                echo "<option value=\"$ville\" $selected>$ville</option>";
            }
            ?>
        </select>
        <button type="submit" name="meteo">Voir Température</button>
    </form>

    <div id="result">
        <?php 
        if (isset($_POST['meteo'])) {
            $city = $_POST['city'];
            $API = 'c3076c16f8a2c96369e9be00b937fec7'; 
            $url = "https://api.openweathermap.org/data/2.5/weather?q=$city&units=metric&lang=fr&appid=$API";

            $reponse = @file_get_contents($url, true); // @ évite les erreurs visibles si l'URL échoue
            if ($reponse === FALSE) {
                echo "❌ Impossible de récupérer les données météo. Vérifie la clé API ou la connexion.";
            } else {
                $donnees = json_decode($reponse, true);
                echo "<h2>Météo à " . htmlspecialchars($city) . "</h2>";
                echo "🌡 Température : " . $donnees['main']['temp'] . "°C<br>";
                echo "💧 Humidité : " . $donnees['main']['humidity'] . "%<br>";
                echo "🌤 Conditions : " . ucfirst($donnees['weather'][0]['description']);
            }
        }
        ?>
    </div>
</body>
</html>
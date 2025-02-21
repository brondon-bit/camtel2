<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root"; // Remplace par ton utilisateur MySQL
$password = ""; // Remplace par ton mot de passe si nécessaire
$database = "contact_db"; // Remplace par le nom de ta base de données

$conn = new mysqli($servername, $username, $password, $database);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Récupération des données du formulaire
$nom = $_POST['name'] ?? '';
$telephone = $_POST['phone'] ?? '';
$service = $_POST['service'] ?? '';
$message = $_POST['message'] ?? '';

// Vérifier que les champs obligatoires sont remplis
if (!empty($nom) && !empty($telephone)) {
    // Préparer la requête SQL avec une requête préparée pour éviter les injections SQL
    $stmt = $conn->prepare("INSERT INTO messages (nom, telephone, service, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nom, $telephone, $service, $message);

    if ($stmt->execute()) {
        $messageStatus = "Message envoyé avec succès.";
    } else {
        $messageStatus = "Erreur : " . $conn->error;
    }

    $stmt->close();
} else {
    $messageStatus = "Veuillez remplir tous les champs obligatoires.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="contact.css">
</head>
<body>
    <header>
        <h1>CAMTEL JOINT</h1>
    </header>

    <nav>
        <ul>
            <li><a href="index.html">Accueil</a></li>
            <li><a href="service.html">Nos Services</a></li>
            <li><a href="#" class="active">Contact</a></li>
            <li><a href="propos.html">À propos</a></li>
        </ul>
    </nav>

    <main>
        <div class="banner">
            <h1>Contactez-nous en cas de problème sur vos différents sites</h1>
        </div>

        <div class="formulaire">
            <div class="form-container">
                <form action="contact.php" method="POST">
                    <div class="input-group">
                        <label for="name">Votre Nom *</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="input-group">
                        <label for="phone">Téléphone *</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    
                    <div class="input-group">
                        <label for="service">Service</label>
                        <select id="service" name="service">
                            <option>XTREME NET</option>
                            <option>E-BILL</option>
                            <option>BLUE</option>
                        </select>
                    </div>
                    
                    <div class="input-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" placeholder="Comment pouvons-nous vous aider ?"></textarea>
                    </div>

                    <div class="input-group">
                        <button type="submit">Envoyer</button>
                    </div>
                </form>

                
               
            </div>
        </div>
    </main>
</body>
</html>
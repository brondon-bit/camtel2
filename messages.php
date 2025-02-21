<?php
$servername = "localhost";
$username = "root"; 
$password = "";
$database = "contact_db"; 

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer les messages
$sql = "SELECT * FROM messages";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Requetes</title>
    <link rel="stylesheet" href="message.css"> 
</head>
<body>
    <header>
        <h1>Gestion des Requetes</h1>
    </header>

    <main>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Service</th>
                    <th>Message</th>
                    <th>Date d'envoi</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['nom']}</td>
                                <td>{$row['telephone']}</td>
                                <td>{$row['service']}</td>
                                <td>{$row['message']}</td>
                                <td>{$row['date_envoi']}</td>
                                <td>
                                    <a href='supprimer_message.php?id={$row['id']}'>Supprimer</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Aucun message reçu</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>

<?php
$conn->close();
?>
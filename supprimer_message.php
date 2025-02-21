<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "contact_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérifier si un ID est passé en paramètre
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sécuriser l'ID

    // Supprimer le message
    $sql = "DELETE FROM messages WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Message supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression.";
    }

    $stmt->close();
} else {
    echo "ID du message non spécifié.";
}

$conn->close();

// Redirection vers la page de gestion des messages
header("Location: messages.php");
exit();
?>
<?php
include 'config.php'; // Inclure la connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifie si un fichier image a été envoyé
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Récupérer l'image
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        
        // Préparer la requête SQL
        $stmt = $conn->prepare("INSERT INTO images (image) VALUES (?)");
        $stmt->bind_param("b", $imageData); // "b" pour blob
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Image enregistrée avec succès.";
        } else {
            echo "Erreur lors de l'enregistrement de l'image.";
        }

        $stmt->close();
    } else {
        echo "Aucune image reçue.";
    }
}

$conn->close();
?>

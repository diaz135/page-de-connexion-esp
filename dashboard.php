<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- Lien vers le fichier CSS -->
    <title>Tableau de bord ESP32-CAM</title>
</head>
<body>
    <div class="container">
        <h1>Bienvenue <?php echo $_SESSION['username']; ?> !</h1>

        <!-- Affichage du flux vidéo -->
        <h2>Flux vidéo de l'ESP32-CAM</h2>
        <iframe src="http://192.168.1.115" width="640" height="480" frameborder="0"></iframe>

        <!-- Commandes pour contrôler l'ESP32-CAM -->
        <h2>Commandes</h2>
        <button class="btn btn-primary" onclick="takePhoto()">Prendre une photo</button>
    </div>

    <script>
        function takePhoto() {
            fetch('http://192.168.1.115/capture')
                .then(response => response.blob())
                .then(blob => {
                    let url = window.URL.createObjectURL(blob);
                    let a = document.createElement('a');
                    a.href = url;
                    a.download = 'photo.jpg';
                    document.body.appendChild(a);
                    a.click();
                    a.remove();

                    // Enregistrer l'image dans la base de données
                    var formData = new FormData();
                    formData.append('image', blob);

                    fetch('enregistrer_image.php', {
                        method: 'POST',
                        body: formData
                    }).then(response => response.text())
                      .then(data => console.log(data));
                })
                .catch(error => console.error('Erreur:', error));
        }
    </script>
</body>
</html>

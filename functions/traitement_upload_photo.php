<?php
//permet d'accèder aux variables de session (ici pour savoir quel utilisateur est connecté).
session_start();
// importation du fichier qui initialise la connexion PDO à la base de donnée.
require_once 'config/database.php';
// Récupération de l'iD utilisateur connecté depuis la session pour pouvoir mettre à jour sa ligne dans la base de données.
$userId = $_SESSION['user_id'];
// vérification que le fichier a bien été envoyé --- vérification du champ et si l'upload se fait bien alors aucune erreur.
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
    // le dossier cible où est enregistrer la photo
    $dossier = 'uploads/profils/';
    // chemin temporaire généré par PHP lors de l'upload
    $fileTmp = $_FILES['photo']['tmp_name'];
    // nom d'origine du fichier (nettoyé avec basename() pour éviter les chemins de type /../../)
    $fileName = basename($_FILES['photo']['name']);
    // chemin complet où sera enregistré le fichier sur mon serveur (on ajoute tim() pour éviter les doublons)
    $filePath = $dossier . time() . '_' . $fileName;

    // Sécurité : on vérifie l’extension
    // format autorisés stocker dans cette variable
    $extensionsAutorisees = ['jpg', 'jpeg', 'png'];
    // extraction de l'extension du fichier
    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    // vérification que l'extension soit autorisée
    if (in_array($extension, $extensionsAutorisees)) {
        // déplace le fichier de son emplacement temporaire vers mon dossier
        move_uploaded_file($fileTmp, $filePath);

        // Enregistrement du chemin dans la BDD
        // prépare une requete SQL pour mettre à jour la colonne de plus :photo et :id sont des placeholders sécurisés pour éviter l'injection SQL
        $stmt = $pdo->prepare("UPDATE users SET profilphoto_user = :photo WHERE id_user = :id");
        // exécute et lie les valeurs de la requête
        $stmt->execute(['photo' => $filePath, 'id' => $userId]);
        // redirection de l'utilisateur vers le dashboard avec un paramêtre pour afficher un message de confirmation.
        header('Location: dashboard.php?upload=success');
        exit();
        // gestion des erreurs
    } else {
        echo "Format non autorisé";
    }
} else {
    echo "Erreur lors de l'upload.";
}
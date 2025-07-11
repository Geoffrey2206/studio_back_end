<?php
//connexion base de donnée
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 📊 Fonction pour compter les nouveaux messages
function compterNouveauxMessages($pdo) {
    $requete = "SELECT COUNT(*) FROM contacts WHERE statut = 'nouveau'";
    $resultat = $pdo->query($requete);
    return $resultat->fetchColumn(); // Retourne juste le nombre
}

// 📋 Fonction pour récupérer tous les messages
function getTousLesMessages($pdo) {
    $requete = "SELECT * FROM contacts ORDER BY date_creation DESC";
    $resultat = $pdo->query($requete);
    return $resultat->fetchAll();
}

// 🔍 Fonction pour rechercher dans les messages
function rechercherMessages($pdo, $terme) {
    $requete = "SELECT * FROM contacts
                WHERE nom LIKE ? 
                OR email_contact LIKE ? 
                OR subject_contact LIKE ? 
                OR message_contact LIKE ?
                ORDER BY creationdate_contact DESC";
    
    $stmt = $pdo->prepare($requete);
    $termeLike = "%$terme%"; // On ajoute les % pour la recherche
    $stmt->execute([$termeLike, $termeLike, $termeLike, $termeLike]);
    
    return $stmt->fetchAll();
}

// ✏️ Fonction pour changer le statut d'un message
function changerStatutMessage($pdo, $id, $nouveauStatut) {
    $requete = "UPDATE contacts SET statut = ? WHERE id = ?";
    $stmt = $pdo->prepare($requete);
    return $stmt->execute([$nouveauStatut, $id]);
}

// 🗑️ Fonction pour supprimer un message
function supprimerMessage($pdo, $id) {
    $requete = "DELETE FROM contact WHERE id = ?";
    $stmt = $pdo->prepare($requete);
    return $stmt->execute([$id]);
}

// 👤 Fonction pour compter les utilisateurs actifs
function compterUtilisateursActifs($pdo) {
    $requete = "SELECT COUNT(*) FROM users WHERE statut = 'actif'";
    $resultat = $pdo->query($requete);
    return $resultat->fetchColumn();
}

//suppression utilisateur dashboard admin
function deleteUser(PDO $pdo, int $id_user): bool {
    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id_user = :id");
        $stmt->execute([':id' => $id_user]);
        return true;
    } catch (PDOException $e) {
        // Log ou echo si besoin : $e->getMessage();
        return false;
    }
}
// suppression d'articles dashboard admin/modérateur
function deleteArticle(PDO $pdo, int $id_article): bool {
    try {
        $stmt = $pdo->prepare("DELETE FROM articles WHERE id_article = :id");
        $stmt->execute([':id' => $id_article]);
        return true;
    } catch (PDOException $e) {
        // Tu peux logger $e->getMessage() ici si besoin
        return false;
    }
}
// fonctions création utilisateur 
function createUser(PDO $pdo, string $name, string $surname, string $email, string $role, string $status, string $plainPassword): bool {
    // 1. Hasher le mot de passe pour la BDD
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    try {
        // 2. Insertion BDD
        $stmt = $pdo->prepare("
            INSERT INTO users (name_user, surname_user, email_user, role_user, status_user, password_user, subscriptiondate_user) 
            VALUES (:name, :surname, :email, :role, :status, :password, NOW())
        ");
        $stmt->execute([
            ':name' => $name,
            ':surname' => $surname,
            ':email' => $email,
            ':role' => $role,
            ':status' => $status,
            ':password' => $hashedPassword
        ]);

        // 3. Envoi email (avec le mot de passe en clair)
        try {
            sendAccountEmail($name, $surname, $email, $plainPassword);
        } catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage()
    ]);
    exit;
}

        return true;

    } catch (Exception $e) {
        error_log("Erreur d'insertion ou d'envoi de mail : " . $e->getMessage());
        return false;
    }
}
// message automatique d'envoie après création d'un nouvel utilisateur par l'administrateur - dashboard admin - gestion utilisateur.
function sendAccountEmail($name, $surname, $email, $plainPassword): bool {
    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth   = true;
        $mail->Username   = '545cb9174d27ca';
        $mail->Password   = '12541a46930d28';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('contact@monsite.com', 'Le Studio - Admin');
        $mail->addAddress($email, "$name $surname");
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Bienvenue au "Le Studio" - Vos accès';
        $mail->Body    = "
            <h3>Bienvenue $name $surname !</h3>
            <p>Votre compte a bien été créé.</p>
            <p><strong>Identifiant :</strong> $email</p>
            <p><strong>Mot de passe :</strong> $plainPassword</p>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Erreur envoi mail : " . $e->getMessage());
        return false;
    }
}
// fonctions pour marquer "lu" - dashboard admin - contact message.
function marquerMessageCommeLu($pdo, $id_contact) {
    try {
        $stmt = $pdo->prepare("UPDATE contact SET status_contact = 'lu' WHERE id_contact = :id AND status_contact = 'nouveau'");
        return $stmt->execute(['id' => $id_contact]);
    } catch (PDOException $e) {
        // Pour débug ou journalisation
        error_log("Erreur mise à jour message lu : " . $e->getMessage());
        return false;
    }
}

// ✏️ Fonction pour modifier un utilisateur existant (admin - dashboard utilisateur)
function updateUser(PDO $pdo, int $id, string $name, string $surname, string $email, string $role, string $status): bool {
    try {
        $stmt = $pdo->prepare("
            UPDATE users 
            SET name_user = :name,
                surname_user = :surname,
                email_user = :email,
                role_user = :role,
                status_user = :status
            WHERE id_user = :id
        ");
        return $stmt->execute([
            ':name' => $name,
            ':surname' => $surname,
            ':email' => $email,
            ':role' => $role,
            ':status' => $status,
            ':id' => $id
        ]);
    } catch (PDOException $e) {
        error_log("Erreur mise à jour utilisateur : " . $e->getMessage());
        return false;
    }
}
// GESTION DES ROLES D ACCES UTILISATEUR
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'Administrateur';
}

function isModerator() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'Modérateur';
}

function isUser() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'Utilisateur';
}
// gestion de redimensionnement des images upload pour les articles.
function resizeImage($sourcePath, $destPath, $newWidth, $newHeight) {
    list($width, $height) = getimagesize($sourcePath);
    $srcImage = imagecreatefromstring(file_get_contents($sourcePath));
    $dstImage = imagecreatetruecolor($newWidth, $newHeight);

    imagealphablending($dstImage, false);
    imagesavealpha($dstImage, true);

    imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    $extension = strtolower(pathinfo($destPath, PATHINFO_EXTENSION));
    switch ($extension) {
        case 'jpg':
        case 'jpeg':
            imagejpeg($dstImage, $destPath, 85);
            break;
        case 'png':
            imagepng($dstImage, $destPath);
            break;
    }

    imagedestroy($srcImage);
    imagedestroy($dstImage);
}
?>
<?php
session_start();

header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/fonctions.php';

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté.']);
    exit;
}

// Vérifie le token CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(['success' => false, 'message' => 'Token CSRF invalide.']);
    exit;
}

// Vérifie l'ID
if (!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID article manquant.']);
    exit;
}

$id_article = (int) $_POST['id'];
$user_id = $_SESSION['user_id'];

try {
    // 🔥 SÉCURITÉ : Vérifier que l'article appartient à l'utilisateur
    $stmt = $pdo->prepare("SELECT img_thumbnail, img_small, img_medium, img_large FROM articles WHERE id_article = ? AND id_user = ?");
    $stmt->execute([$id_article, $user_id]);
    $imagePaths = $stmt->fetch();

    if (!$imagePaths) {
        echo json_encode(['success' => false, 'message' => 'Article introuvable ou non autorisé.']);
        exit;
    }

    // Supprimer les images associées
    foreach ($imagePaths as $img) {
        var_dump($imagePaths);
        if ($img && !empty($img)) {
            // 🔥 Chemin corrigé - depuis le dossier functions/
            $absolutePath = __DIR__ . '/../' . $img;
            if (file_exists($absolutePath)) {
                unlink($absolutePath);
                error_log("Image supprimée: " . $absolutePath);
            }
        }
    }

    // 🔥 Suppression directe en BDD avec vérification utilisateur
    $stmt = $pdo->prepare("DELETE FROM articles WHERE id_article = ? AND id_user = ?");
    $result = $stmt->execute([$id_article, $user_id]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Article supprimé avec succès.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Aucun article supprimé.']);
    }

} catch (PDOException $e) {
    error_log("Erreur suppression article: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erreur base de données.']);
}
?>
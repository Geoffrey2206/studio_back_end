<?php
// 🔍 Affiche toutes les erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 🚪 Démarre la session et prépare la réponse JSON
session_start();
header('Content-Type: application/json');

// 🔌 Connexion et fonctions
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/fonctions.php';

// 🔐 Vérifications de sécurité
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté.']);
    exit;
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(['success' => false, 'message' => 'Token CSRF invalide.']);
    exit;
}

if (!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID article manquant.']);
    exit;
}

// 🧠 Variables
$id_article = (int) $_POST['id'];
$user_id = $_SESSION['user_id'];

try {
    // 🔍 Récupère les chemins d’images de l'article
    $stmtImages = $pdo->prepare("SELECT img_thumbnail, img_small, img_medium, img_large FROM articles WHERE id_article = ? AND id_user = ?");
    $stmtImages->execute([$id_article, $user_id]);
    $imagePaths = $stmtImages->fetch();

    // 📦 Récupère le contenu de l'article (pour supprimer les images TinyMCE insérées dans le texte)
    $stmtContenu = $pdo->prepare("SELECT content_article FROM articles WHERE id_article = ? AND id_user = ?");
    $stmtContenu->execute([$id_article, $user_id]);
    $article = $stmtContenu->fetch();

    if (!$imagePaths && !$article) {
        echo json_encode(['success' => false, 'message' => 'Article introuvable ou non autorisé.']);
        exit;
    }

    // 🧹 Suppression des images insérées dans le contenu (drag and drop TinyMCE)
    if ($article && !empty($article['content_article'])) {
    $contenu = $article['content_article'];

         // Recherche toutes les balises <img src="...">
        preg_match_all('/<img[^>]+src="([^">]+)"/i', $contenu, $matches);
        $imagesTiny = $matches[1] ?? [];

        foreach ($imagesTiny as $imgSrc) {
            $relativePath = parse_url($imgSrc, PHP_URL_PATH);
            $localPath = realpath(__DIR__ . '/../' . ltrim($relativePath, '/'));

            if ($localPath && file_exists($localPath)) {
                unlink($localPath);
                error_log("🧹 Image TinyMCE supprimée : $localPath");
            } else {
                error_log("⚠️ Image TinyMCE introuvable : $localPath");
            }
        }
        error_log("🧪 Image détectée dans TinyMCE : " . $imgSrc);
        error_log("📁 Chemin local traduit : " . $localPath);
    }

    // 🧹 Suppression des images uploadées via l’input
    if ($imagePaths) {
        foreach ($imagePaths as $imgPath) {
            if (!empty($imgPath)) {
                $absolutePath = __DIR__ . '/../' . $imgPath;
                if (file_exists($absolutePath)) {
                    unlink($absolutePath);
                    error_log("🧨 Image supprimée: " . $absolutePath);
                } else {
                    error_log("⚠️ Image introuvable: " . $absolutePath);
                }
            }
        }

        // 🔄 Supprime toutes les variantes (thumb_, medium_, etc.)
        if (!empty($imagePaths['img_large'])) {
            $basePath = str_replace(['thumb_', 'small_', 'medium_', 'large_'], '', $imagePaths['img_large']);
            $directory = dirname(__DIR__ . '/../' . $basePath) . '/';
            $filename = basename($basePath, '.' . pathinfo($basePath, PATHINFO_EXTENSION));
            $extension = pathinfo($basePath, PATHINFO_EXTENSION);

            $variants = ['', 'thumb_', 'small_', 'medium_', 'large_'];
            foreach ($variants as $variant) {
                $filePath = $directory . $variant . $filename . '.' . $extension;
                if (file_exists($filePath)) {
                    unlink($filePath);
                    error_log("🧨 Variante supprimée : $filePath");
                }
            }
        }
    }

    // 🗑️ Suppression de l'article en base
    $stmtDelete = $pdo->prepare("DELETE FROM articles WHERE id_article = ? AND id_user = ?");
    $stmtDelete->execute([$id_article, $user_id]);

    if ($stmtDelete->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Article supprimé avec succès.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Aucun article supprimé.']);
    }

} catch (PDOException $e) {
    error_log("❌ Erreur PDO : " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Erreur base de données : ' . $e->getMessage()
    ]);
}
?>
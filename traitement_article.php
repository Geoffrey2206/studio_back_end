<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/functions/fonctions.php';

// 1. Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit;
}

$userId = $_SESSION['user_id'];

// 2. Vérifie le token CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(['success' => false, 'message' => 'Token CSRF invalide']);
    exit;
}

// 3. Vérifie les champs requis
if (empty($_POST['titre']) || empty($_POST['contenu']) || empty($_POST['statut'])) {
    echo json_encode(['success' => false, 'message' => 'Champs manquants']);
    exit;
}

// Ajoutez ceci au début de traitement_article.php après session_start()
error_log("=== LIMITES PHP ===");
error_log("post_max_size: " . ini_get('post_max_size'));
error_log("upload_max_filesize: " . ini_get('upload_max_filesize'));
error_log("max_execution_time: " . ini_get('max_execution_time'));
error_log("memory_limit: " . ini_get('memory_limit'));
error_log("Taille POST reçue: " . $_SERVER['CONTENT_LENGTH'] ?? 'inconnue');

// Vérification si POST est trop volumineux
if (empty($_POST) && empty($_FILES) && $_SERVER['CONTENT_LENGTH'] > 0) {
    $displayMaxSize = ini_get('post_max_size');
    echo json_encode([
        'success' => false, 
        'message' => "Données trop volumineuses. Maximum autorisé: {$displayMaxSize}"
    ]);
    exit;
}

// 4. Préparation des données
$titre = htmlspecialchars($_POST['titre']);
$contenu = $_POST['contenu'];
$statut = $_POST['statut'];
$img_alt = isset($_POST['img_alt']) ? htmlspecialchars($_POST['img_alt']) : '';
$articleId = isset($_POST['article_id']) && !empty($_POST['article_id']) ? (int)$_POST['article_id'] : null;

// 🔥 Debug - Ajoutez ceci pour voir ce qui arrive
error_log("=== DEBUG TRAITEMENT ARTICLE ===");
error_log("POST data: " . print_r($_POST, true));
error_log("FILES data: " . print_r($_FILES, true));
error_log("Article ID: " . ($articleId ?? 'nouveau'));

// 5. Gestion de l'image
$dossier = 'uploads/articles/';
if (!is_dir($dossier)) {
    mkdir($dossier, 0755, true);
}

$img_small = $img_thumb = $img_medium = $img_large = null;

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    error_log("Image détectée: " . $_FILES['image']['name']);
    
    $tmpPath = $_FILES['image']['tmp_name'];
    $fileName = basename($_FILES['image']['name']);
    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($extension, $allowedExt)) {
        echo json_encode(['success' => false, 'message' => 'Format d\'image non autorisé']);
        exit;
    }

    $timestamp = time();
    $safeName = $timestamp . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $fileName);

    $img_original = $dossier . $safeName;
    $img_thumb    = $dossier . 'thumb_' . $safeName;
    $img_small    = $dossier . 'small_' . $safeName;
    $img_medium   = $dossier . 'medium_' . $safeName;
    $img_large    = $dossier . 'large_' . $safeName;

    if (move_uploaded_file($tmpPath, $img_original)) {
        error_log("Image uploadée avec succès: " . $img_original);
        
        // 🔥 Vérification et gestion des erreurs de redimensionnement
        $resizeSuccess = true;
        
        if (function_exists('resizeImage')) {
            $resizeSuccess &= resizeImage($img_original, $img_thumb, 150, 150);
            $resizeSuccess &= resizeImage($img_original, $img_small, 300, 200);
            $resizeSuccess &= resizeImage($img_original, $img_medium, 600, 400);
            $resizeSuccess &= resizeImage($img_original, $img_large, 900, 600);
            
            if (!$resizeSuccess) {
                error_log("Échec du redimensionnement - utilisation de l'image originale");
                // En cas d'échec, utilisez l'image originale
                $img_thumb = $img_original;
                $img_small = $img_original;
                $img_medium = $img_original;
                $img_large = $img_original;
            }
        } else {
            error_log("Fonction resizeImage non trouvée");
            // Utilisez l'image originale
            $img_thumb = $img_original;
            $img_small = $img_original;
            $img_medium = $img_original;
            $img_large = $img_original;
        }
    } else {
        error_log("Erreur lors du déplacement du fichier");
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'upload']);
        exit;
    }
} else {
    if (isset($_FILES['image'])) {
        error_log("Erreur upload: " . $_FILES['image']['error']);
    } else {
        error_log("Aucun fichier image reçu");
    }
}

// 6. Insertion ou mise à jour en base de données
try {
    if ($articleId) {
        // 🔥 MODE MODIFICATION
        if ($img_thumb) {
            // Avec nouvelle image
            $stmt = $pdo->prepare("
                UPDATE articles 
                SET title_article = :title, content_article = :content, statut = :statut,
                    img_thumbnail = :thumb, img_medium = :medium, img_large = :large, 
                    img_small = :small, img_alt = :img_alt
                WHERE id_article = :id AND id_user = :user_id
            ");
            $params = [
                'title' => $titre,
                'content' => $contenu,
                'statut' => $statut,
                'thumb' => $img_thumb,
                'medium' => $img_medium,
                'large' => $img_large,
                'small' => $img_small,
                'img_alt' => $img_alt,
                'id' => $articleId,
                'user_id' => $userId
            ];
        } else {
            // Sans nouvelle image (garde les anciennes)
            $stmt = $pdo->prepare("
                UPDATE articles 
                SET title_article = :title, content_article = :content, statut = :statut
                WHERE id_article = :id AND id_user = :user_id
            ");
            $params = [
                'title' => $titre,
                'content' => $contenu,
                'statut' => $statut,
                'id' => $articleId,
                'user_id' => $userId
            ];
        }
        
        $stmt->execute($params);
        echo json_encode(['success' => true, 'message' => 'Article modifié avec succès']);
        
    } else {
        // 🔥 MODE CRÉATION
        $stmt = $pdo->prepare("
            INSERT INTO articles 
            (title_article, content_article, created_at, id_user, statut, img_thumbnail, img_medium, img_large, img_small, img_alt)
            VALUES 
            (:title, :content, NOW(), :user_id, :statut, :thumb, :medium, :large, :small, :img_alt)
        ");

        $stmt->execute([
            'title' => $titre,
            'content' => $contenu,
            'user_id' => $userId,
            'statut' => $statut,
            'thumb' => $img_thumb,
            'medium' => $img_medium,
            'large' => $img_large,
            'small' => $img_small,
            'img_alt' => $img_alt
        ]);

        echo json_encode(['success' => true, 'message' => 'Article créé avec succès']);
    }

} catch (PDOException $e) {
    error_log("Erreur SQL: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erreur SQL : ' . $e->getMessage()]);
}

?>
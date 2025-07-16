<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/functions/fonctions.php';
require_once 'functions/html_purifer.php';

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

// Log des limites PHP
error_log("=== LIMITES PHP ===");
error_log("post_max_size: " . ini_get('post_max_size'));
error_log("upload_max_filesize: " . ini_get('upload_max_filesize'));
error_log("max_execution_time: " . ini_get('max_execution_time'));
error_log("memory_limit: " . ini_get('memory_limit'));
error_log("Taille POST reçue: " . ($_SERVER['CONTENT_LENGTH'] ?? 'inconnue'));

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
$contenu_propre = cleanHtml($contenu);
$statut = $_POST['statut'];
$img_alt = isset($_POST['img_alt']) ? htmlspecialchars($_POST['img_alt']) : '';
$articleId = isset($_POST['article_id']) && !empty($_POST['article_id']) ? (int)$_POST['article_id'] : null;

// Debug
error_log("=== DEBUG TRAITEMENT ARTICLE ===");
error_log("POST data: " . print_r($_POST, true));
error_log("FILES data: " . print_r($_FILES, true));
error_log("Article ID: " . ($articleId ?? 'nouveau'));
error_log("User ID: " . $userId);


// 5. Gestion de l'image
$dossier = 'uploads/articles/';
if (!is_dir($dossier)) {
    mkdir($dossier, 0755, true);
}

$img_small = $img_thumb = $img_medium = $img_large = null;
$hasNewImage = false;

// Vérification si une nouvelle image est envoyée
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $hasNewImage = true;
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

    // 🧹 RÉCUPÉRATION ET SUPPRESSION DES ANCIENNES IMAGES (si c'est une modification)
    $oldImages = [];
    if ($articleId && $hasNewImage) {
        try {
            $stmt = $pdo->prepare("SELECT img_thumbnail, img_small, img_medium, img_large FROM articles WHERE id_article = ? AND id_user = ?");
            $stmt->execute([$articleId, $userId]);
            $oldImages = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($oldImages) {
                foreach ($oldImages as $label => $imgPath) {
                    $fullPath = __DIR__ . '/' . $imgPath;
                    if (file_exists($fullPath)) {
                        if (unlink($fullPath)) {
                            error_log("🗑️ Ancienne image supprimée ($label): $fullPath");
                        } else {
                            error_log("❌ Impossible de supprimer $fullPath");
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            error_log("Erreur suppression anciennes images: " . $e->getMessage());
        }
    }

    // Upload de la nouvelle image
    if (move_uploaded_file($tmpPath, $img_original)) {
        error_log("✅ Image uploadée avec succès: " . $img_original);

        // Redimensionnement
        $resizeSuccess = true;
        $resizeSuccess &= resizeImage($img_original, $img_thumb, 150, 150);
        $resizeSuccess &= resizeImage($img_original, $img_small, 300, 200);
        $resizeSuccess &= resizeImage($img_original, $img_medium, 600, 400);
        $resizeSuccess &= resizeImage($img_original, $img_large, 900, 600);
           

            if (!$resizeSuccess) {
                error_log("⚠️ Échec du redimensionnement - utilisation de l'image originale");
                $img_thumb = $img_original;
                $img_small = $img_original;
                $img_medium = $img_original;
                $img_large = $img_original;
            } else {
                // Supprimer l'image originale après redimensionnement réussi
                if (file_exists($img_original)) {
                    unlink($img_original);
                    error_log("🗑️ Image originale supprimée après redimensionnement");
                }
            }
    }
} elseif (isset($_FILES['image']) && $_FILES['image']['error'] !== 4) {
    // Si une image a été envoyée mais avec une autre erreur (pas "no file uploaded")
    error_log("❌ Erreur lors de l'upload : " . $_FILES['image']['error']);
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'upload (' . $_FILES['image']['error'] . ')']);
    exit;
} else {
    // Aucun fichier => modification de texte uniquement
    $hasNewImage = false;
    error_log("ℹ️ Pas de nouvelle image, mise à jour du contenu uniquement");
}
// La section else suivante est inutile ici et provoquait une accolade non appariée

// 6. Insertion ou mise à jour en base de données
$userId = $_SESSION['user_id'];
$userRole = $_SESSION['role'];

if ($articleId) {
    $stmt = $pdo->prepare("SELECT id_user FROM articles WHERE id_article = ?");
    $stmt->execute([$articleId]);
    $article = $stmt->fetch();

    if (!$article) {
        exit(json_encode(['success' => false, 'message' => 'Article introuvable']));
    }

    // Vérification des droits
    $isOwner = $article['id_user'] == $userId;
    $isAdmin = $userRole === 'Administrateur';
    $isModerator = $userRole === 'Modérateur';

    if (!($isAdmin || ($isModerator && $isOwner))) {
        exit(json_encode(['success' => false, 'message' => '⛔ Accès refusé']));
    }
}
try {
    if ($articleId) {
        // 🔥 MODE MODIFICATION
        if ($hasNewImage) {
            // Mise à jour AVEC nouvelle image
            $stmt = $pdo->prepare("
                UPDATE articles 
                SET title_article = :title, content_article = :content, statut = :statut,
                    img_thumbnail = :thumb, img_medium = :medium, img_large = :large, 
                    img_small = :small, img_alt = :img_alt, updated_at = NOW()
                WHERE id_article = :id 
            
            ");
            $params = [
                'title' => $titre,
                'content' => $contenu_propre,
                'statut' => $statut,
                'thumb' => $img_thumb,
                'medium' => $img_medium,
                'large' => $img_large,
                'small' => $img_small,
                'img_alt' => $img_alt,
                'id' => $articleId,
                
            ];
            
            error_log("Mise à jour avec nouvelle image - params: " . print_r($params, true));
        } else {
            // Mise à jour SANS nouvelle image (seul le texte alt peut être modifié)
            $stmt = $pdo->prepare("
                UPDATE articles 
                SET title_article = :title, content_article = :content, statut = :statut, 
                    img_alt = :img_alt, updated_at = NOW()
                WHERE id_article = :id 
            ");
            $params = [
                'title' => $titre,
                'content' => $contenu_propre,
                'statut' => $statut,
                'img_alt' => $img_alt,
                'id' => $articleId,
                
            ];
            
            error_log("Mise à jour sans nouvelle image - params: " . print_r($params, true));
        }
        
        $result = $stmt->execute($params);
        
        error_log("=== RÉSULTAT EXÉCUTION UPDATE ===");
        error_log("Résultat execute(): " . ($result ? 'TRUE' : 'FALSE'));
        error_log("Requête SQL: " . $stmt->queryString);
        
        if ($result) {
            $rowsAffected = $stmt->rowCount();
            error_log("Lignes affectées: " . $rowsAffected);
            
            if ($rowsAffected > 0) {
                // 🔁 Récupérer la date de mise à jour
                $stmtDate = $pdo->prepare("SELECT updated_at FROM articles WHERE id_article = ?");
                $stmtDate->execute([$articleId]);
                $updated_at = $stmtDate->fetchColumn();

                echo json_encode([
                    'success' => true,
                    'message' => 'Article modifié avec succès',
                    'updated_at' => date('d/m/Y', strtotime($updated_at))
                ]);
                exit;
            } else {
                // Vérifier pourquoi aucune ligne n'a été affectée
                error_log("❌ Aucune ligne affectée - Vérification des paramètres:");
                error_log("Article ID existe: " . ($articleId ? 'OUI' : 'NON'));
                error_log("User ID: " . $userId);
                
                // Vérifier si l'article existe avec ces paramètres
                $verifyStmt = $pdo->prepare("SELECT COUNT(*) as count FROM articles WHERE id_article = ? AND id_user = ?");
                $verifyStmt->execute([$articleId, $userId]);
                $count = $verifyStmt->fetchColumn();
                
                error_log("Articles trouvés avec ID=$articleId et USER=$userId: " . $count);
                
                if ($count == 0) {
                    echo json_encode(['success' => false, 'message' => 'Article non trouvé ou vous n\'avez pas les permissions']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Aucune modification détectée - données identiques']);
                }
            }
        } else {
            error_log("❌ Échec de l'exécution de la requête UPDATE");
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour']);
        }
        
    } else {
        // 🔥 MODE CRÉATION
        $stmt = $pdo->prepare("
            INSERT INTO articles 
            (title_article, content_article, created_at, id_user, statut, img_thumbnail, img_medium, img_large, img_small, img_alt)
            VALUES 
            (:title, :content, NOW(), :user_id, :statut, :thumb, :medium, :large, :small, :img_alt)
        ");

        $params = [
            'title' => $titre,
            'content' => $contenu_propre,
            'user_id' => $userId,
            'statut' => $statut,
            'thumb' => $img_thumb,
            'medium' => $img_medium,
            'large' => $img_large,
            'small' => $img_small,
            'img_alt' => $img_alt
        ];

        error_log("Création nouvel article - params: " . print_r($params, true));
        
        $result = $stmt->execute($params);
        
        if ($result) {
            // Récupérer l'ID du nouvel article pour les images drag&drop
            $articleId = $pdo->lastInsertId();
            echo json_encode(['success' => true, 'message' => 'Article créé avec succès']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la création']);
        }
    }

} catch (PDOException $e) {
    error_log("Erreur SQL: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erreur SQL : ' . $e->getMessage()]);
}

// 7. Gestion des images drag & drop dans le contenu
preg_match_all('/uploads\/articles\/[^"]+\.(jpg|jpeg|png|webp)/i', $contenu, $matches);
$imagesDansContenu = array_unique($matches[0]);

if (!empty($imagesDansContenu)) {
    try {
        // Utiliser l'ID de l'article (soit existant, soit nouvellement créé)
        if ($articleId) {
            $stmt = $pdo->prepare("UPDATE articles SET images_dragdrop = :images WHERE id_article = :id");
            $stmt->execute([
                'images' => json_encode($imagesDansContenu),
                'id' => $articleId
            ]);
            error_log("✅ Images drag&drop enregistrées: " . json_encode($imagesDansContenu));
        }
    } catch (PDOException $e) {
        error_log("Erreur enregistrement images drag&drop : " . $e->getMessage());
    }
};

?>
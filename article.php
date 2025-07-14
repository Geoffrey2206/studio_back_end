<?php
$page = basename($_SERVER['PHP_SELF'],'.php'); 
$pageTitle = "Article - Salle de sport";

require_once __DIR__ . '/config/database.php'; // ou ajuste ton chemin
require_once __DIR__ . '/includes/header.php';

// Sécurité : cast de l’ID
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Récupération de l'article
$stmt = $pdo->prepare("
    SELECT a.*, u.name_user, u.surname_user 
    FROM articles a
    JOIN users u ON a.id_user = u.id_user
    WHERE a.id_article = :id
");
$stmt->execute(['id' => $id]);
$article = $stmt->fetch();

if (!$article) {
    echo '<div class="container my-5"><div class="alert alert-danger">Article introuvable.</div></div>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}
?>
    <div class="container my-5">
        <a href="blog.php" class="btn btn-outline-secondary mb-4">← Retour aux articles</a>
        
        <h1 class="mb-3"><?= htmlspecialchars($article['title_article']) ?></h1>
        <p class="text-muted mb-4">
            Par <?= htmlspecialchars($article['name_user'] . ' ' . $article['surname_user']) ?>
            – le <?= date('d/m/Y', strtotime($article['created_at'])) ?>
        </p>       
        <?php if (!empty($article['img_large'])): ?>
        <div class="article-image-wrapper mb-4">
            <picture>
                <source srcset="<?= htmlspecialchars($article['img_thumbnail']) ?>" media="(max-width: 150px)">
                <source srcset="<?= htmlspecialchars($article['img_small']) ?>" media="(max-width: 480px)">
                <source srcset="<?= htmlspecialchars($article['img_medium']) ?>" media="(max-width: 768px)">
                <source srcset="<?= htmlspecialchars($article['img_large']) ?>">
                <img src="<?= htmlspecialchars($article['img_large']) ?>"
                    alt="<?= htmlspecialchars($article['img_alt'] ?? '') ?>"
                    class="article-image"
                    >
            </picture>
        </div>
        <?php endif; ?>
        <div class="article-content">
            <?= $article['content_article'] ?> <!-- doit déjà être purifié avec HTMLPurifier -->
        </div>
    </div>

    
    <?php require_once __DIR__ . '/includes/footer.php'; ?>
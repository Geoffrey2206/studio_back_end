<?php 
require_once 'config/database.php';
require_once 'functions/html_purifer.php'; // ✅ AJOUT

$query = $pdo->query("
    SELECT a.*, u.name_user, u.surname_user 
    FROM articles a
    JOIN users u ON a.id_user = u.id_user
    WHERE statut = 'publie'
    ORDER BY created_at DESC
");

$articles = $query->fetchAll();
foreach ($articles as &$article) {
    $article['content_article'] = cleanHtml($article['content_article']);
}
unset($article); // Libère la référence
?>
<?php $page = basename($_SERVER['PHP_SELF'],'.php'); ?>
<?php $pageTitle = "Blog - Salle de sport"?>
<?php include __DIR__ . '/includes/header.php'; ?>
<?php include __DIR__ . '/includes/sections/blog/section_blog.php'; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
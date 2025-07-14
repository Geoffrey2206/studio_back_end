<?php 
require_once 'config/database.php';

$query = $pdo->query("
    SELECT a.*, u.name_user, u.surname_user 
    FROM articles a
    JOIN users u ON a.id_user = u.id_user
    WHERE statut = 'publie'
    ORDER BY created_at DESC
");

$articles = $query->fetchAll();
?>
<?php $page = basename($_SERVER['PHP_SELF'],'.php'); ?>
<?php $pageTitle = "Blog - Salle de sport"?>
<?php include __DIR__ . '/includes/header.php'; ?>
<?php include __DIR__ . '/includes/sections/blog/section_blog.php'; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
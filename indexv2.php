<?php $page = basename($_SERVER['PHP_SELF'],'.php'); ?>
<?php $pageTitle = "Accueil - Salle de sport"?>

<?php include __DIR__ . '/includes/header.php'; ?>
<?php include __DIR__ . '/includes/sections/index/sections_presta.php'; ?>
<?php include __DIR__ . '/includes/sections/index/sections_activities.php'; ?>
<?php include __DIR__ . '/includes/sections/index/sections_actualites.php'; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
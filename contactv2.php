<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Récupération des messages
$success = $_SESSION['success'] ?? '';
$erreurs = $_SESSION['erreurs'] ?? [];
$old = $_SESSION['old'] ?? [];

// Nettoyage de la session
?>
<?php $page = basename($_SERVER['PHP_SELF'],'.php'); ?>
<?php $pageTitle = "Contact - Salle de sport"?>
<?php
$old = $_SESSION["old"] ?? [];
$erreurs = $_SESSION["erreurs"] ?? [];
?>
<?php include __DIR__ . '/includes/header.php'; ?>
<!-- ==========================================================================
SECTION - Formulaire et Coordonnées
Description : Contient le formulaire de contact et les coordonnées du studio
========================================================================== --> 
<section class="contact-section">
    <div class="row justify-content-center">
        <?php include __DIR__ . '/functions/formulaire-de-contact.php'; ?>
        
        <?php include __DIR__ . '/includes/sections/contact/section_contact.php'; ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>

<?php
unset($_SESSION['success'], $_SESSION['erreurs'], $_SESSION['old']);
?>
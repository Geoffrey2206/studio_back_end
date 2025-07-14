<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../vendor/autoload.php'; // Ajout autoload Composer pour PHPMailer et autres dépendances

// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrateur') {
//     header('Location: login.php');
//     exit;
// }

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Administrateur') {
    // Tu peux logger ou déboguer ici si tu veux
    echo "⛔ Accès refusé : rôle non administrateur";
    exit;
}

?>

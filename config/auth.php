<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('Location: ../login.php');
    exit;
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
// Si le rôle n'est pas reconnu, on refuse l'accès
$allowed_roles = ['Administrateur', 'Modérateur', 'Utilisateur'];
if (!in_array($_SESSION['role'], $allowed_roles)) {
    echo "⛔ Accès refusé : rôle inconnu.";
    exit;
}
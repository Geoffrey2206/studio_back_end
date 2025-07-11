<?php
session_start();
require_once __DIR__ . '/config/database.php';
// mise en place de la vérification d'identification et du switch entre le dashboard utilisateur et administrateur voir redirection si pas de compte.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Recherche de l'utilisateur
    $stmt = $pdo->prepare("SELECT id_user, password_user, role_user, email_user FROM users WHERE email_user = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

   
    if (password_verify($password, $user['password_user'])) {
        
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['role'] = $user['role_user'];

        if ($user['role_user'] === 'Administrateur') {
            header('Location: dashboardv2.php');
        } else {
            header('Location: dashboardv2.php');
        }
        exit;
    } else {
        $_SESSION['error'] = "Email ou mot de passe incorrect.";
        header('Location: login.php');
        exit;
    }
}
<?php
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/fonctions.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Suppression utilisateur
    if (isset($_POST['delete_user_id'])) {
        $userId = intval($_POST['delete_user_id']);
        if (deleteUser($pdo, $userId)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression.']);
        }
        exit;
    }

    // Création utilisateur
    if (isset($_POST['create_user'])) {
        $name = $_POST['name_user'] ?? '';
        $surname = $_POST['surname_user'] ?? '';
        $email = $_POST['email_user'] ?? '';
        $role = $_POST['role_user'] ?? 'Utilisateur';
        $status = $_POST['status_user'] ?? 'actif';
        $password = $_POST['password_user'] ?? '';

        if (createUser($pdo, $name, $surname, $email, $role, $status, $password)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la création de l’utilisateur.']);
        }
        exit;
    }

    // ✅ Mise à jour utilisateur
    if (isset($_POST['update_user'])) {
        $id = intval($_POST['id_user'] ?? 0);
        $name = $_POST['name_user'] ?? '';
        $surname = $_POST['surname_user'] ?? '';
        $email = $_POST['email_user'] ?? '';
        $role = $_POST['role_user'] ?? 'Utilisateur';
        $status = $_POST['status_user'] ?? 'actif';

        if ($id > 0 && updateUser($pdo, $id, $name, $surname, $email, $role, $status)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour.']);
        }
        exit;
    }

    // ❌ Aucune action correspondante
    echo json_encode(['success' => false, 'message' => 'Requête invalide.']);
    exit;
}
?>
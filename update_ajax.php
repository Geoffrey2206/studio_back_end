<?php
require_once 'config/database.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id_user'];
    $name = $_POST['name_user'];
    $surname = $_POST['surname_user'];
    $email = $_POST['email_user'];
    $role = $_POST['role_user'];
    $status = $_POST['status_user']; // 🟢 Important !

    $stmt = $pdo->prepare("UPDATE users 
        SET name_user = :name,
            surname_user = :surname,
            email_user = :email,
            role_user = :role,
            status_user = :status
        WHERE id_user = :id");

    $stmt->execute([
        ':name' => $name,
        ':surname' => $surname,
        ':email' => $email,
        ':role' => $role,
        ':status' => $status,
        ':id' => $id
    ]);

    echo json_encode(['success' => true]);
    exit();
}
?>
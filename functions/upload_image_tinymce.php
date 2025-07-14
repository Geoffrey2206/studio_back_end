<?php
// filepath: c:\wamp64\www\PHP-sport\Le-studio---GYMS\functions\upload_image_tinymce.php
session_start();
header('Content-Type: application/json');

// Vérification utilisateur connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit;
}

// Vérification du fichier
if (!isset($_FILES['file']) || $_FILES['file']['error'] !== 0) {
    echo json_encode(['success' => false, 'message' => 'Aucun fichier reçu']);
    exit;
}

$file = $_FILES['file'];
$allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];

if (!in_array($file['type'], $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => 'Type de fichier non autorisé']);
    exit;
}

// Taille max 5MB
if ($file['size'] > 5 * 1024 * 1024) {
    echo json_encode(['success' => false, 'message' => 'Fichier trop volumineux (max 5MB)']);
    exit;
}

// Dossier de destination
$uploadDir = __DIR__ . '/../uploads/tinymce/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Nom de fichier sécurisé
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$fileName = uniqid('tinymce_', true) . '.' . $extension;
$filePath = $uploadDir . $fileName;

if (move_uploaded_file($file['tmp_name'], $filePath)) {
    // Retourner l'URL relative pour TinyMCE
    $fileUrl = 'uploads/tinymce/' . $fileName;
    echo json_encode(['success' => true, 'location' => $fileUrl]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'upload']);
}
?>
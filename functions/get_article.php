<?php
require_once __DIR__ . '/../config/database.php';
header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID manquant']);
    exit;
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM articles WHERE id_article = :id");
$stmt->execute(['id' => $id]);
$article = $stmt->fetch();

if ($article) {
    echo json_encode(['success' => true, 'article' => $article]);
} else {
    echo json_encode(['success' => false, 'message' => 'Article introuvable']);
}
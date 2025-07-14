<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/functions/fonctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id_contact = (int) $_POST['id'];
    $success = marquerMessageCommeLu($pdo, $id_contact);
    echo $success ? 'ok' : 'erreur';
}
?>
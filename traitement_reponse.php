<?php
session_start();
require_once __DIR__ . '/config/database.php'; // adapter si besoin

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_contact'] ?? null;
    $reponse = trim($_POST['reponse'] ?? '');

    if ($id && $reponse) {
        try {
            // ➤ 1. Mise à jour de la réponse dans la base de données
            $stmt = $pdo->prepare("UPDATE contacts SET reponse_contact = :reponse, status_contact = 'répondu' WHERE id_contact = :id");
            $stmt->execute([
                ':reponse' => $reponse,
                ':id' => $id
            ]);

            // ➤ 2. Envoi d’email si demandé (depuis formulaire)
            if (isset($_POST['send_email']) && $_POST['send_email'] === '1') {
                $stmt = $pdo->prepare("SELECT email_contact FROM contacts WHERE id_contact = :id");
                $stmt->execute([':id' => $id]);
                $email = $stmt->fetchColumn();

                if ($email) {
                    require __DIR__ . '/vendor/autoload.php';
                    require_once __DIR__ . '/includes/envoie.php';

                    $mailResult = envoyerReponseAvecSMTP($email, $reponse);
                    if (!$mailResult['success']) {
                        $_SESSION['errors']['mail'] = "Erreur d'envoi du mail : " . $mailResult['message'];
                    }
                }
            }

            // ➤ 3. Message de succès (même si le mail échoue, la réponse est enregistrée)
            $_SESSION['success'] = "Réponse enregistrée avec succès !";

        } catch (PDOException $e) {
            $_SESSION['errors']['bdd'] = "Erreur base de données : " . $e->getMessage();
        }
    } else {
        $_SESSION['errors']['form'] = "Tous les champs sont obligatoires.";
    }
}

// ➤ 4. Redirection vers l'onglet contact du dashboard
header("Location: dashboardv2.php?page=contacts");
exit;

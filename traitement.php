<?php
ob_start();
session_start();
// Inclusion des fonctions et PHPMailer
require __DIR__ . '/vendor/autoload.php'; // Ou le chemin vers PHPMailer
require __DIR__ . '/includes/envoie.php';
require_once __DIR__ . '/config/database.php'; //la on préparer la réception pour stocker les données envoier par mail dans la base de donnée.

function verifierAntiSpam($data) {
    // Vérifier la fréquence d'envoi
    $ip = $_SERVER['REMOTE_ADDR'];
    $dernierEnvoi = $_SESSION['dernier_envoi'] ?? 0;
    $maintenant = time();
    
    if ($maintenant - $dernierEnvoi < 60) { // 1 minute minimum
        return false;
    }
    
    // Vérifier les mots interdits
    $motsInterdits = ['spam', 'viagra', 'casino', 'bitcoin'];
    $texte = strtolower($data['message']);
    
    foreach ($motsInterdits as $mot) {
        if (strpos($texte, $mot) !== false) {
            return false;
        }
    }
    
    return true;
}
// Vérification de la méthode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contactv2.php');
    exit;
}

// Récupération des données
$nom = $_POST['nom'] ?? '';
$prenom = $_POST['prenom'] ?? '';
$tel = $_POST['tel'] ?? '';
$email = $_POST['email'] ?? '';
$sujet = $_POST['sujet'] ?? '';
$message = trim($_POST['msg'] ?? '');
var_dump($message);
var_dump($sujet);
var_dump($email);
var_dump($tel);
var_dump($prenom);
var_dump($nom);

// Sauvegarde pour réaffichage en cas d'erreur
$_SESSION['old'] = [
    'nom' => $nom,
    'prenom' => $prenom,
    'tel' => $tel,
    'email' => $email,
    'sujet' => $sujet,
    'msg' => $message
];

// Nettoyage des données
$nom = trim(htmlspecialchars($nom));
$prenom = trim(htmlspecialchars($prenom));
$tel = trim(htmlspecialchars($tel));
$email = trim(htmlspecialchars($email));
$sujet = trim($sujet);
$message = trim($message);

// Validation
$erreurs = [];

// Validation du nom
if (empty($nom)) {
    $erreurs['nom'] = "Le nom est obligatoire.";
} elseif (strlen($nom) < 2) {
    $erreurs['nom'] = "Le nom doit contenir au moins 2 caractères.";
} elseif (strlen($nom) > 100) {
    $erreurs['nom'] = "Le nom ne peut pas dépasser 100 caractères.";
}
// Validation du prénom
if (empty($prenom)) {
    $erreurs['prenom'] = "Le prénom est obligatoire.";
} elseif (strlen($prenom) < 2) {
    $erreurs['prenom'] = "Le prénom doit contenir au moins 2 caractères.";
} elseif (strlen($prenom) > 100) {
    $erreurs['prenom'] = "Le prénom ne peut pas dépasser 100 caractères.";
}
// Validation du téléphone
if (empty($tel)) {
    $erreurs['tel'] = "Le téléphone est obligatoire.";
} elseif (!preg_match('/^[0-9 +().-]{8,20}$/', $tel)) {
    $erreurs['tel'] = "Le téléphone n'est pas valide.";
}
// Validation de l'email
if (empty($email)) {
    $erreurs['email'] = "L'email est obligatoire.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erreurs['email'] = "L'email n'est pas valide.";
} elseif (strlen($email) > 255) {
    $erreurs['email'] = "L'email est trop long.";
}
// Validation du sujet
if (empty($sujet)) {
    $erreurs['sujet'] = "Le sujet est obligatoire.";
} elseif (strlen($sujet) < 2) {
    $erreurs['sujet'] = "Le sujet doit contenir au moins 2 caractères.";
} elseif (strlen($sujet) > 255) {
    $erreurs['sujet'] = "Le sujet ne peut pas dépasser 255 caractères.";
}
// Validation du message
if (empty($message)) {
    $erreurs['msg'] = "Le message est obligatoire.";
} elseif (strlen($message) < 10) {
    $erreurs['msg'] = "Le message doit contenir au moins 10 caractères.";
} elseif (strlen($message) > 2000) {
    $erreurs['msg'] = "Le message ne peut pas dépasser 2000 caractères.";
}

// S'il y a des erreurs, retour au formulaire
if (!empty($erreurs)) {
    $_SESSION['erreurs'] = $erreurs;
    header('Location: contactv2.php');
    exit;
}
// insertion dans base de donnée
try {
    $requete = "INSERT INTO contacts 
        (name, surname_contact, email_contact, subject_contact, creationdate_contact, status_contact, message_contact, phone_contact) 
        VALUES (:nom, :prenom, :email, :sujet, CURDATE(), 'nouveau', :msg, :tel)";

    $stmt = $pdo->prepare($requete);
    $stmt->execute(
        [
            ':nom' =>  $nom,
            ':prenom' =>$prenom,
            ':email' =>$email,
            ':sujet' =>$sujet,
            ':msg' =>$message,
            ':tel' =>$tel
            ]);
    $_SESSION['db_success'] = "Message enregistré dans la base de données.";
} catch (PDOException $e) {
    $_SESSION['erreurs'] = ['general' => "Erreur BDD : " . $e->getMessage()];
    header('Location: contactv2.php');
    exit;
}
// Tentative d'envoi de l'email
$resultat = envoyerEmail([
    'nom' => $nom,
    'prenom' => $prenom,
    'tel' => $tel,
    'email' => $email,
    'sujet' => $sujet,
    'msg' => $message,
]);

// Nettoyage des anciennes valeurs
unset($_SESSION['old']);

// Gestion du résultat
if ($resultat['success']) {
    $_SESSION['success'] = $resultat['message'];
} else {
    $_SESSION['erreurs'] = ['general' => $resultat['message']];
}

// Redirection
header('Location: contactv2.php');
exit;
ob_end_flush();
?>
<?php
$serveur = 'localhost';
$baseDeDonnees = 'studio';
$utilisateur = 'root';
$motDePasse = '';


try {
    // 🎯 On essaie de se connecter
    $pdo = new PDO("mysql:host=$serveur;dbname=$baseDeDonnees;charset=utf8", $utilisateur, $motDePasse);
    
    // 🛡️ On dit à PDO d'être strict sur les erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // echo "✅ Connexion réussie !";
    
} catch (Exception $e) {
    // 🚨 Si ça ne marche pas, on affiche l'erreur
    echo "❌ Erreur : " . $e->getMessage();
    die(); // On arrête le script
}
$requete = "
    SELECT 
        id_contact,
        name,
        surname_contact,
        email_contact,
        subject_contact,
        creationdate_contact,
        message_contact,
        reponse_contact,
        status_contact,
        CONCAT(name, ' ', surname_contact) AS full_name
    FROM contacts 
    ORDER BY creationdate_contact DESC
";
// ✅ Exécute la requête AVANT d’appeler fetchAll()
$resultat = $pdo->query($requete);
$contacts = $resultat->fetchAll();

$requete = "SELECT id_user, name_user, surname_user, CONCAT(name_user,' ',surname_user) AS nom_complet, email_user, role_user,status_user,id_user, subscriptiondate_user FROM users";
$resultat = $pdo->query($requete);

// 📦 On récupère tous les résultats
$users = $resultat->fetchAll();
?>

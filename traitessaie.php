<?php

session_start();
// je récupère les saisies de "nom" "email" et "message"
$inputs = ["nom", "email", "message"];
// je créer une variable ou je vais stocker mon tableau d'erreur pour ma session
$erreurs = [];
// c'est ma variables qui va stocker l'ensemble de mes valeurs utilisateurs
$valeurs = [];


// Je fais une boucle pour que les champs défile les uns après les autres 
foreach ($inputs as $input) {
    // j'ai une variable "valeur" qui va me permettre de stocker le champ en cours et qui va automatiquement enlever les espaces et prendre une saisie nulle.
    $valeur = trim($_POST[$input] ?? '');
    
    $valeurs[$input] = $valeur;
    // si la valeur est === '' alors la variable erreur va se remplir avec un champs.
    if ($valeur === '') {
        $erreurs[$input] = "Le champ $input est requis.";
    } else{
        if($input === "email" && !preg_match("/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,}$/",$valeur)) {
            $erreurs[$input] = "l'email n'est pas valide.";
        }
       if ($input === "nom" && !preg_match("/^[a-zA-ZÀ-ÿ'\-\s]+$/u", $valeur)) {
            $erreurs[$input] = "Le nom ne doit contenir que des lettres, espaces, tirets ou apostrophes.";
       }
       if ($input === "message" && mb_strlen($valeur) < 10) {
            $erreurs[$input] = "Le message requière 10 caractères au plus.";
        }
    }
}

// S'il y a des erreurs, on redirige vers le formulaire
if (!empty($erreurs)) {
    $_SESSION["erreurs"] = $erreurs;
    $_SESSION["old"] = $valeurs;
    header("Location: form.php");
    exit;
}

// Traitement du formulaire si aucune erreur
unset($_SESSION["erreurs"]); // On vide les erreurs au cas où

echo "<h2 class=text-primary>Merci " . htmlspecialchars($_POST["nom"]) . " votre message est bien envoyé!</h2>";
echo "<p class='text-primary'>Email : " . htmlspecialchars($_POST["email"]) . "</p>";
echo "<p class='text-primary'>Message : " . nl2br(htmlspecialchars($_POST["message"])) . "</p>";
?>
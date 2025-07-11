<?php
session_start();
require_once __DIR__ . '/config/database.php';

// Traitement du formulaire d’inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($name) && !empty($email) && !empty($password)) {
        // Vérifie si l'email est déjà utilisé
        $checkEmail = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email_user = ?");
        $checkEmail->execute([$email]);

        if ($checkEmail->fetchColumn() > 0) {
            $_SESSION['error'] = "Cet email est déjà utilisé.";
        } else {
            // Hash du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insertion dans la BDD
            $stmt = $pdo->prepare("INSERT INTO users (surname_user, email_user, password_user, role_user, status_user, subscriptiondate_user) 
                                   VALUES (?, ?, ?, 'Utilisateur', 'active', NOW())");

            $stmt->execute([$name, $email, $hashedPassword]);

            $_SESSION['success'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        }
    } else {
        $_SESSION['error'] = "Tous les champs sont obligatoires.";
    }
}
?>

<?php $pageTitle = "Inscription - Salle de sport"; ?>
<?php include __DIR__ . '/includes/header.php'; ?>

<main style="background-image: url(assets/img/bg_inscription.png); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 100vh;">
    <section class="row justify-content-center">
        <div class="col-12 col-md-6 contact-form px-md-3 px-4 py-5 bg-color-dark" style="margin-top: 5rem;">
            <!-- Message de succès ou d'erreur -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                    <br><a href="login.php" class="btn btn-success mt-2">Se connecter</a>
                </div>
            <?php endif; ?>

            <!-- Titre et lien vers login -->
            <h2 class="text-center text-white mb-4">Créer un compte</h2>
            <p class="text-center text-light">
                Déjà inscrit ? 
                <a href="login.php" class="text-warning" style="text-decoration: underline;">Se connecter</a>
            </p>

            <!-- Formulaire d'inscription -->
            <form method="POST">
                <div class="mb-3">
                    <input class="form-control" name="username" placeholder="Nom d'utilisateur" required>
                </div>
                <div class="mb-3">
                    <input class="form-control" name="email" type="email" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input class="form-control" name="password" type="password" placeholder="Mot de passe" required>
                </div>
                <div>
                    <button class="btn btn-primary w-100" type="submit">S'inscrire</button>
                </div>
            </form>
        </div>
    </section>
</main>
</html>

<?php
session_start();
?>
<?php include __DIR__ . '/includes/header.php'; ?>
<?php $page = basename($_SERVER['PHP_SELF'],'.php'); ?>
<?php $pageTitle = "Connexion - Salle de sport"?>

    <main class="bg-fond">
        <div class="login-container">
            <h2 class="text">Connexion</h2>
            <?php if (isset($_SESSION['error'])): ?>
                <p style="color:red"><?= $_SESSION['error'] ?></p>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            <form action="login_process.php" method="POST" class="login-form">
                <label for="email" class="text">Email :</label>
                <input type="email" name="email" required>
                <label for="password" class="text">Mot de passe :</label>
                <input type="password" name="password" required>
                <button type="submit">Se connecter</button>
            </form>
        </div>
    </main>
</body>
</html>
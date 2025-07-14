<?php
session_start();
?>
<?php $page = basename($_SERVER['PHP_SELF'],'.php'); ?>
<?php $pageTitle = "Connexion - Salle de sport"?>
<?php include __DIR__ . '/includes/header.php'; ?>
<style>
/* Styles pour la modal d'inscription */
.modal {
    z-index: 9999 !important;
}

.modal-backdrop {
    z-index: 9998 !important;
}

.modal-content {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    border: 1px solid #444;
    border-radius: 15px;
}

.modal-header {
    border-bottom: 1px solid #444;
    background: transparent;
}

.modal-title {
    color: #fff;
    font-family: 'Oswald', sans-serif;
    font-weight: 600;
}

.btn-close {
    filter: invert(1);
}

.modal-body {
    color: #fff;
}

.form-label {
    color: #fff;
    font-weight: 500;
}

.form-control {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid #555;
    color: #fff;
    border-radius: 8px;
}

.form-control:focus {
    background: rgba(255, 255, 255, 0.15);
    border-color: #007bff;
    color: #fff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.form-control::placeholder {
    color: #aaa;
}

.btn-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
}
</style>
    <main class="bg-fond d-flex align-items-center min-vh-100">
        <section class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4 bg-color-dark">
                    <!-- Message d'erreur -->
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                    <?php endif; ?>
                
                    <!-- Titre et lien vers inscription -->
                    <h2 class="text-center text-white mb-4">Connexion</h2>
                    <p class="text-center text-light">
                        Pas encore de compte ?
                        <a href="inscription.php" class="text-warning" style="text-decoration: underline;">S'inscrire</a>
                    </p>
                   <!-- Formulaire de connexion -->
                    <form action="login_process.php" method="POST" class="login-form">
                        <div class="mb-3">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-gold w-100">Se connecter</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
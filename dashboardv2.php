<?php
require_once __DIR__ . '/config/auth.php'; // Protection pour tous les rôles
require_once __DIR__ . '/functions/fonctions.php';
require_once __DIR__ . '/config/database.php';

// Traitement suppression utilisateur (protégé en backend)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    if (isAdmin()) {
        require_once __DIR__ . '/functions/fichier_qui_supprime.php';
    }
    header("Location: admin.php?page=utilisateurs");
    exit;
}

// Inclusion des éléments visuels communs
include __DIR__ . '/includes/sections/dashboard/dashboard_header.php';
include __DIR__ . '/includes/sections/dashboard/dashboard_sidebar.php';
?>

<main class="main-content">
    <?php
    // page demandée par URL
    $page = htmlspecialchars($_GET['page'] ?? 'content');

    // Pages accessibles selon les rôles
    $allowed_pages = ['profile_utilisateur', 'content'];

    if (isAdmin()) {
        $allowed_pages = array_merge($allowed_pages, [
            'users', 'contacts', 'articles', 'settings'
        ]);
    } elseif (isModerator()) {
        $allowed_pages = array_merge($allowed_pages, [
            'users', 'contacts', 'articles'
        ]);
    }

    // Inclusion conditionnelle
    if (in_array($page, $allowed_pages)) {
        include __DIR__ . "/includes/sections/dashboard/dashboard_{$page}.php";
    } else {
        echo "⛔ Accès interdit ou page inexistante.";
    }
    ?>
</main>

<?php
include __DIR__ . '/includes/sections/dashboard/modals.php';
include __DIR__ . '/includes/sections/dashboard/dashboard_footer_admin.php';
?>
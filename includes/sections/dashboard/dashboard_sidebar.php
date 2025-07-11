<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
} ?>
<?php require_once __DIR__ . '/../../../functions/fonctions.php'; // ou chemin relatif correct ?>
<?php $currentPage = $_GET['page'] ?? 'content'; ?>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="p-4">
            <h4 class="text-white mb-4">
                <i class="fas fa-cogs me-2"></i>
                Admin Panel
            </h4>
        </div>
        <ul class="nav flex-column">
            <?php if (isAdmin()) : ?>    
            <li class="nav-item">
                <a class="nav-link <?= $currentPage === 'content' ? 'active' : '' ?>" href="dashboardv2.php?page=content">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link <?= $currentPage === 'contacts' ? 'active' : '' ?>" href="dashboardv2.php?page=contacts">
                    <i class="fas fa-envelope"></i>
                    Messages Contact
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $currentPage === 'users' ? 'active' : '' ?>" href="dashboardv2.php?page=users"> 
                    <i class="fas fa-users"></i>
                    Gestion Utilisateurs
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $currentPage === 'articles' ? 'active' : '' ?>" href="dashboardv2.php?page=articles"> 
                    <i class="fas fa-newspaper"></i>
                    Articles
                </a>
            </li>
            <?php if (isAdmin()) : ?>
            <li class="nav-item">
                <a class="nav-link <?= $currentPage === 'settings' ? 'active' : '' ?>" href="dashboardv2.php?page=settings">
                    <i class="fas fa-cog"></i>
                    Paramètres
                </a>
            </li>
            <?php endif; ?>
            <li class="nav-item mt-auto">
                <a class="nav-link text-danger" href="/PHP-sport/Le-studio---GYMS/logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    Déconnexion
                </a>
            </li>
        </ul>
    </nav>
  
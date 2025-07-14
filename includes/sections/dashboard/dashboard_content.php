<?php require_once __DIR__ . '/../../../functions/fonctions.php'; // ou chemin relatif correct ?>
<!-- Dashboard Tab -->
<div class="" id="dashboard">
    <div class="header-card">
        <h2 class="mb-3">
            <i class="fas fa-chart-bar me-2"></i>
            Tableau de Bord
        </h2>
        <p class="mb-0">Vue d'ensemble de votre administration</p>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stats-card">
                <div class="stats-icon" style="background: linear-gradient(135deg, var(--success-color), #229954);">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3 class="fw-bold mb-1">24</h3>
                <p class="text-muted mb-0">Nouveaux messages</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stats-card">
                <div class="stats-icon" style="background: linear-gradient(135deg, var(--accent-color), #2980b9);">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="fw-bold mb-1">156</h3>
                <p class="text-muted mb-0">Utilisateurs actifs</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stats-card">
                <div class="stats-icon" style="background: linear-gradient(135deg, var(--warning-color), #e67e22);">
                    <i class="fas fa-clock"></i>
                </div>
                <h3 class="fw-bold mb-1">8</h3>
                <p class="text-muted mb-0">En attente</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stats-card">
                <div class="stats-icon" style="background: linear-gradient(135deg, var(--danger-color), #c0392b);">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="fw-bold mb-1">89%</h3>
                <p class="text-muted mb-0">Taux de réponse</p>
            </div>
        </div>
    </div>
</div>
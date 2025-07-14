<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../functions/fonctions.php'; // ajuste si besoin

// Génère un token CSRF si non défini
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$query = $pdo->query("
    SELECT a.*, u.name_user, u.surname_user 
    FROM articles a
    JOIN users u ON a.id_user = u.id_user
    ORDER BY a.created_at DESC
");

$articles = $query->fetchAll();

?>
<div class="header-card">
    <h2><i class="fas fa-newspaper me-2"></i> Gestion des Articles</h2>
    <p class="mb-0">Administrez tous les articles du blog</p>
</div>

<div class="table-container">
    <div class="row mb-3">
        <!-- Recherche -->
        <div class="col-md-6">
            <div class="search-box d-flex align-items-center">
                <i class="fas fa-search me-2"></i>
                <input type="text" class="form-control" placeholder="Rechercher un article...">
            </div>
        </div>

        <!-- Boutons -->
        <div class="col-md-6 text-end d-flex justify-content-end gap-2">
            <!-- Créer un article -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#articleModal">
                <i class="fas fa-plus me-1"></i> Nouvel article
            </button>

            <!-- Filtrage (à activer plus tard en AJAX) -->
            <button class="btn btn-outline-secondary" id="filterBtn">
                <i class="fas fa-filter me-1"></i> Filtrer
            </button>
        </div>
    </div>
</div>

<!-- Tableau -->
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="articlesTableBody">
            <?php foreach ($articles as $article): ?>
                <tr>
                    <td><?= htmlspecialchars($article['title_article']) ?></td>
                    <td><?= htmlspecialchars($article['name_user'] . ' ' . $article['surname_user']) ?></td>
                    <td><?= date('d/m/Y', strtotime($article['created_at'])) ?></td>
                    <td>
                        <?php
                        $status = $article['statut'] ?? 'brouillon';
                        $badgeClass = match ($status) {
                            'publie' => 'bg-success',
                            'brouillon' => 'bg-warning',
                            default => 'bg-secondary'
                        };
                        ?>
                        <span class="badge <?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                    </td>
                    <td class="d-flex gap-2">
                       <button 
                            class="btn btn-warning btn-sm edit-article-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#articleModal"
                            data-id="<?= $article['id_article'] ?>"
                            data-title="<?= htmlspecialchars($article['title_article'], ENT_QUOTES) ?>"
                            data-content="<?= htmlspecialchars($article['content_article'], ENT_QUOTES) ?>"
                            data-statut="<?= $article['statut'] ?>"
                        >
                            <i class="fas fa-edit"></i>
                        </button>
                        <button 
                            class="btn btn-danger btn-sm delete-article-btn"
                            data-id="<?= $article['id_article'] ?>"
                        >
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
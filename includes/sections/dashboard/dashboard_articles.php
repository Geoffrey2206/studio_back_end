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
$auteursUniques = array_unique(array_map(fn($a) => $a['name_user'] . ' ' . $a['surname_user'], $articles)); 

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
                <input type="text" class="form-control" id="search-article" placeholder="Rechercher un article...">
            </div>
        </div>

        <!-- Boutons -->
        <div class="col-md-6 text-end d-flex justify-content-end gap-2">
            <!-- Créer un article -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#articleModal">
                <i class="fas fa-plus me-1"></i> Nouvel article
            </button>

            <!-- Filtrage (à activer plus tard en AJAX) -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownFilterBtn" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-filter me-1"></i> Filtrer
                </button>
                <div class="dropdown-menu p-3 shadow" aria-labelledby="dropdownFilterBtn" style="min-width: 300px;">
                    <div class="mb-3">
                        <label for="filterStatus" class="form-label">Statut</label>
                        <select class="form-select" id="filterStatus">
                            <option value="">Tous</option>
                            <option value="publie">Publié</option>
                            <option value="brouillon">Brouillon</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="filterAuthor" class="form-label">Auteur</label>
                        <select class="form-select" id="filterAuthor">
                            <option value="">Tous</option>
                            <!-- Ces options doivent être générées dynamiquement en PHP -->
                            <?php foreach ($auteursUniques as $auteur): ?>
                                <option value="<?= htmlspecialchars($auteur) ?>"><?= htmlspecialchars($auteur) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="filterDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="filterDate">
                    </div>
                    <button class="btn btn-primary w-100" id="applyFilterBtn">Appliquer</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tableau -->
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="articlesTableBody">
            
            <?php foreach ($articles as $article): ?>
                <tr data-id="<?= $article['id_article'] ?>">
                    <td class="d-flex align-items-center gap-3">
                        <?php if (!empty($article['img_thumbnail'])): ?>
                            <img src="/PHP-sport/Le-studio---GYMS/<?= htmlspecialchars($article['img_thumbnail']) ?>" 
                            alt="Miniature de l'article" 
                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
                        <?php else: ?>
                            <img src="/PHP-sport/Le-studio---GYMS/img/default-thumb.png" 
                            alt="Miniature par défaut" 
                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="article-title"><?= htmlspecialchars($article['title_article']) ?></span>
                    </td>
                    <td><?= htmlspecialchars($article['name_user'] . ' ' . $article['surname_user']) ?></td>
                    <td class="date-cell"><?= date('d/m/Y', strtotime($article['updated_at'] ?? $article['created_at'])) ?></td>
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
                    <?php
                    $currentUserId = $_SESSION['user_id'] ?? null;
                    $currentUserRole = $_SESSION['role'] ?? '';

                    $isOwner = $article['id_user'] == $currentUserId;
                    $isAdmin = $currentUserRole === 'Administrateur';
                    $isModerator = $currentUserRole === 'Modérateur';

                    // ADMIN = peut tout faire
                    // MODÉRATEUR = ne peut gérer QUE ses propres articles
                    if ($isAdmin || ($isModerator && $isOwner)) :
                    ?>
                        <button 
                            class="btn btn-warning btn-sm edit-article-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#articleModal"
                            data-id="<?= $article['id_article'] ?>"
                            data-title="<?= htmlspecialchars($article['title_article'], ENT_QUOTES) ?>"
                            data-content="<?= htmlspecialchars($article['content_article'], ENT_QUOTES) ?>"
                            data-statut="<?= $article['statut'] ?>"
                            data-image="<?= htmlspecialchars($article['img_large'] ?? '', ENT_QUOTES) ?>"
                            data-alt="<?= htmlspecialchars($article['img_alt'] ?? '', ENT_QUOTES) ?>"
                        >
                            <i class="fas fa-edit"></i>
                        </button>
                        <button 
                            class="btn btn-danger btn-sm delete-article-btn"
                            data-id="<?= $article['id_article'] ?>"
                        >
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    <?php endif; ?>
                </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/../../../functions/fonctions.php'; // ou chemin relatif correct ?>
<!-- Users Tab -->
<div class="header-card">
    <h2 class="mb-3">
        <i class="fas fa-users me-2"></i>
        Gestion des Utilisateurs
    </h2>
    <p class="mb-0">Gérez les comptes utilisateurs de votre plateforme</p>
</div>

<div class="table-container">
    <div class="row mb-3">
        <!-- Barre de recherche -->
        <div class="col-md-6">
        <div class="search-box d-flex align-items-center">
            <i class="fas fa-search me-2"></i>
            <input type="text" class="form-control" placeholder="Rechercher un utilisateur...">
        </div>
        </div>

        <!-- Boutons à droite -->
        <div class="col-md-6 text-end d-flex justify-content-end gap-2">

        <!-- Bouton Nouvel utilisateur -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
            <i class="fas fa-plus me-1"></i> Nouvel utilisateur
        </button>

        <!-- Bouton de filtre + dropdown custom -->
        <div class="position-relative">
            <button id="filterBtn"  class="btn btn-outline-secondary"><script>console.log("✅ Le bouton filtre est bien là dans le HTML");</script>
            <i class="fas fa-filter me-1"></i> Filtrer
            </button>

            <!-- Menu filtre déroulant personnalisé -->
            <div id="filterDropdown" class="card p-3 mt-2 d-none" style="position: absolute; right: 0; z-index: 999; min-width: 280px;">
            <form id="filterForm" class="d-flex flex-column gap-2">
                <!-- Statut -->
                <div>
                <label for="status" class="form-label mb-0">Statut</label>
                <select name="status" id="status" class="form-select">
                    <option value="">Tous</option>
                    <option value="actif">Actif</option>
                    <option value="inactif">Inactif</option>
                    <option value="suspendu">Suspendu</option>
                </select>
                </div>

                <!-- Rôle -->
                <div>
                <label for="role" class="form-label mb-0">Rôle</label>
                <select name="role" id="role" class="form-select">
                    <option value="">Tous</option>
                    <option value="Administrateur">Administrateur</option>
                    <option value="Modérateur">Modérateur</option>
                    <option value="Utilisateur">Utilisateur</option>
                </select>
                </div>

                <!-- Date d'inscription -->
                <div>
                <label for="date" class="form-label mb-0">Date d'inscription</label>
                <input type="date" name="date" id="date" class="form-control">
                </div>

                <!-- Tri -->
                <div>
                <label for="sort" class="form-label mb-0">Trier par</label>
                <select name="sort" id="sort" class="form-select">
                    <option value="az">Nom (A → Z)</option>
                    <option value="za">Nom (Z → A)</option>
                    <option value="date_recent">Date récente</option>
                    <option value="date_ancienne">Date ancienne</option>
                </select>
                </div>

                <!-- Bouton Appliquer -->
                <button type="submit" class="btn btn-primary mt-2">Appliquer</button>
            </form>
            </div>
        </div>
        </div>
    </div>
</div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Date d'inscription</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($user['nom_complet']) ?></strong><br>
                            <span><?= htmlspecialchars($user['role_user']) ?></span><br>
                        </td>
                        <!-- BOUTONS D'ACTION SOUS LE NOM -->                               
                        <td><?= htmlspecialchars($user['email_user']) ?></td>
                        <td><?= htmlspecialchars($user['role_user']) ?></td>
                        <td><?= htmlspecialchars($user['subscriptiondate_user']) ?></td>
                        <td>
                            <?php
                            $status = $user['status_user'];
                            $badgeClass = match ($status) {
                                'actif' => 'bg-success',   // vert
                                'inactif' => 'bg-danger',  // rouge
                                'suspendu' => 'bg-warning',// orange
                                default => 'bg-secondary'  // gris si statut inconnu
                            };
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($user['status_user']) ?></span>
                        </td>
                        <td class="d-flex justify-content-between">     
                            <button 
                                class="btn btn-warning btn-sm edit-btn"
                                data-id="<?= $user['id_user'] ?>"
                                data-name="<?= htmlspecialchars($user['name_user'] ?? '') ?>"
                                data-surname="<?= htmlspecialchars($user['surname_user'] ?? '') ?>"
                                data-email="<?= htmlspecialchars($user['email_user'] ?? '') ?>"
                                data-role="<?= $user['role_user'] ?>"
                                data-status="<?= $user['status_user'] ?>"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal">
                                <i class="fas fa-edit"></i>
                            </button>
                            <?php if (isAdmin()) : ?>
                            <button type="button"
                                class="btn btn-danger btn-sm delete-user-btn"
                                data-id="<?= $user['id_user'] ?>"
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
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#">Précédent</a>
            </li>
            <li class="page-item active">
                <a class="page-link" href="#">1</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">2</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">3</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">Suivant</a>
            </li>
        </ul>
    </nav>
</div>

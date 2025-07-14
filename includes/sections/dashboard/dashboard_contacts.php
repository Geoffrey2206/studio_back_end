<?php require_once __DIR__ . '/../../../functions/fonctions.php'; // ou chemin relatif correct ?>
<!-- Contacts Tab -->
<div class="" id="contacts">
    <div class="header-card">
        <h2 class="mb-3">
            <i class="fas fa-envelope me-2"></i>
            Gestion des Messages
        </h2>
        <p class="mb-0">Consultez et gérez tous les messages de contact</p>
    </div>

    <div class="table-container">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" placeholder="Rechercher dans les messages...">
                </div>
            </div>
            <div class="col-md-6 text-end">
                                <!-- Bouton de filtre + dropdown custom -->
                <div class="position-relative">
                    <button id="filterBtn" class="btn btn-outline-secondary">
                        <i class="fas fa-filter me-1"></i> Filtrer
                    </button>

                    <!-- Menu filtre déroulant personnalisé -->
                    <div id="filterDropdown" class="card p-3 mt-2 d-none" style="position: absolute; right: 0; z-index: 999; min-width: 280px;">
                        <form id="filterForm" class="d-flex flex-column gap-2">
                            <!-- Statut du message -->
                            <div>
                                <label for="status" class="form-label mb-0">Statut</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">Tous</option>
                                    <option value="nouveau">Nouveau</option>
                                    <option value="lu">Lu</option>
                                    <option value="répondu">Répondu</option>
                                </select>
                            </div>

                            <!-- Date de réception -->
                            <div>
                                <label for="date" class="form-label mb-0">Date de réception</label>
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
                <?php if (isAdmin()) : ?>
                <button class="btn btn-success">
                    <i class="fas fa-download me-1"></i>
                    Exporter
                </button>
                <?php endif; ?>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Expéditeur</th>
                        <th>Email</th>
                        <th>Sujet</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $message) : ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <strong><?= htmlspecialchars($message['full_name']) ?></strong>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($message['email_contact']) ?></td>
                            <td><?= htmlspecialchars($message['subject_contact']) ?></td>
                            <td><?= date('d M Y', strtotime($message['creationdate_contact'])) ?></td>
                            <td>
                                <?php if ($message['status_contact'] === 'nouveau'): ?>
                                    <span class="status-badge status-new">Nouveau</span>
                                <?php elseif ($message['status_contact'] === 'lu'): ?>
                                    <span class="status-badge status-read">Lu</span>
                                <?php elseif ($message['status_contact'] === 'répondu'): ?>
                                    <span class="status-badge status-replied">Répondu</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-primary btn-action open-modal" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewMessageModal" 
                                        data-id="<?= $message['id_contact'] ?>"
                                        data-name="<?= htmlspecialchars($message['name']) ?>"
                                        data-surname="<?= htmlspecialchars($message['surname_contact']) ?>"
                                        data-date="<?= $message['creationdate_contact'] ?>"
                                        data-subject="<?= htmlspecialchars($message['subject_contact']) ?>"
                                        data-message="<?= htmlspecialchars($message['message_contact']) ?>"
                                        data-reponse="<?= htmlentities($message['reponse_contact'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-success btn-action open-reply-modal" 
                                        title="Répondre"
                                        data-id="<?= $message['id_contact'] ?>"
                                        data-name="<?= htmlspecialchars($message['name']) ?>"
                                        data-surname="<?= htmlspecialchars($message['surname_contact']) ?>"
                                        data-subject="<?= htmlspecialchars($message['subject_contact']) ?>"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#replyModal">
                                    <i class="fas fa-reply"></i>
                                </button>
                                <?php if (isAdmin()) : ?>
                                <button class="btn btn-danger btn-action" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <?php endif ?>
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
</div>

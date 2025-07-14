<?php require_once __DIR__ . '/../../../functions/fonctions.php'; // ou chemin relatif correct ?>
<!-- Settings Tab -->
<div class="" id="settings">
    <div class="header-card">
        <h2 class="mb-3">
            <i class="fas fa-cog me-2"></i>
            Paramètres
        </h2>
        <p class="mb-0">Configuration générale de l'administration</p>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="table-container">
                <h5 class="mb-4">
                    <i class="fas fa-envelope me-2"></i>
                    Configuration Email
                </h5>
                <form>
                    <div class="mb-3">
                        <label class="form-label">Email administrateur</label>
                        <input type="email" class="form-control" value="admin@example.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Réponse automatique</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" checked>
                            <label class="form-check-label">Activer</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message automatique</label>
                        <textarea class="form-control" rows="3">Merci pour votre message. Nous vous répondrons dans les plus brefs délais.</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        Sauvegarder
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="table-container">
                <h5 class="mb-4">
                    <i class="fas fa-shield-alt me-2"></i>
                    Sécurité
                </h5>
                <form>
                    <div class="mb-3">
                        <label class="form-label">Authentification à deux facteurs</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox">
                            <label class="form-check-label">Activer 2FA</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Durée de session (minutes)</label>
                        <input type="number" class="form-control" value="60">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tentatives de connexion max</label>
                        <input type="number" class="form-control" value="5">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        Sauvegarder
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="table-container">
                <h5 class="mb-4">
                    <i class="fas fa-database me-2"></i>
                    Sauvegarde et Maintenance
                </h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card border-success mb-3">
                            <div class="card-body text-center">
                                <i class="fas fa-download fa-2x text-success mb-2"></i>
                                <h6>Sauvegarde complète</h6>
                                <p class="text-muted small">Dernière: 22 Juin 2025</p>
                                <button class="btn btn-success btn-sm">
                                    <i class="fas fa-download me-1"></i>
                                    Sauvegarder
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-warning mb-3">
                            <div class="card-body text-center">
                                <i class="fas fa-broom fa-2x text-warning mb-2"></i>
                                <h6>Nettoyage cache</h6>
                                <p class="text-muted small">Dernier: 23 Juin 2025</p>
                                <button class="btn btn-warning btn-sm">
                                    <i class="fas fa-broom me-1"></i>
                                    Nettoyer
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-info mb-3">
                            <div class="card-body text-center">
                                <i class="fas fa-chart-bar fa-2x text-info mb-2"></i>
                                <h6>Optimisation DB</h6>
                                <p class="text-muted small">Dernière: 20 Juin 2025</p>
                                <button class="btn btn-info btn-sm">
                                    <i class="fas fa-cogs me-1"></i>
                                    Optimiser
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
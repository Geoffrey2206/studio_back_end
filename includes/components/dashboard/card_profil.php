<div class="card shadow-sm p-4 mb-4 user-profile-card">
  <div class="d-flex justify-content-center align-items-center">
    <img src="<?= htmlspecialchars($users['profilphoto_user'] ?: 'assets/img/bdd/photo_user_test.jpg') ?>"
         alt="Photo de profil"
         class="rounded-circle me-3"
         style="width: 80px; height: 80px; object-fit: cover;">

    <div>
      <h4 class="mb-0">Bienvenue sur votre espace</h4>
      <h5 class="fw-bold"><?= htmlspecialchars($users['name_user']) ?></h5>
      <p class="text-muted mb-1">Dernière connexion : <?= date('d/m/Y', strtotime($users['lastconnexion_user'])) ?></p>
    </div>
  </div>

  <div class="d-flex justify-content-center mt-3">
    <a href="dashboard.php?page=profil" class="btn btn-outline-primary w-20 mb-2">Modifier mon profil</a>
  </div>

  <div class="d-flex justify-content-center align-items-center">
    <div class="mt-3 p-3 bg-light rounded abonnement">
      <h6 class="fw-bold mb-1">Abonnement : <?= htmlspecialchars($users['subscriptionpackage_user']) ?></h6>
      <p class="mb-1">Date d’abonnement : <?= date('d/m/Y', strtotime($users['subscriptiondate_user'])) ?></p>
      <p class="mb-2">Fin d’abonnement : <strong><?= date('d/m/Y', strtotime($users['subscriptionend_user'])) ?></strong></p>
      <a href="dashboard.php?page=abonnement" class="btn btn-light w-100">Changer de formule</a>
    </div>
  </div>
</div>
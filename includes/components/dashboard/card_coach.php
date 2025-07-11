<?php
require_once 'config/database.php';

$userID = $_SESSION['user_id']; // identifiant de l'utilisateur connecté

try {
    $stmt = $pdo->prepare("
        SELECT c.*
        FROM users u
        JOIN coachs c ON u.coachid_user = c.id_coach
        WHERE u.id_user = :id AND c.actif = 'oui'
    ");
    $stmt->execute(['id' => $userID]);
    $coach = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
<?php if ($coach): ?>
<div class="card-coach d-flex align-items-center justify-content-between p-3 mb-4">
    <div class="d-flex align-items-center">
        <img src="<?= htmlspecialchars($coach['photo_coach']) ?>" alt="Photo de <?= htmlspecialchars($coach['prenom_coach']) ?>" class="rounded-start coach-img">
    </div>
    <div class="flex-grow-1 px-4">
        <h5 class="mb-1">
            <span class="fw-bold border-bottom border-dark">Mon coach personnel :</span>
            <?= htmlspecialchars($coach['prenom_coach']) . ' ' . htmlspecialchars($coach['nom_coach']) ?>
        </h5>
        <p class="fst-italic">"<?= htmlspecialchars($coach['description_coach']) ?>"</p>
        <a href="messagerie.php?dest=<?= urlencode($coach['email_coach']) ?>" class="btn btn-coach">Envoyer un message</a>
    </div>
</div>
<?php else: ?>
    <p class="text-muted">Aucun coach actif pour le moment.</p>
<?php endif; ?>
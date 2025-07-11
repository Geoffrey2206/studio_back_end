<?php
session_start();
$old = $_SESSION["old"] ?? [];
$erreurs = $_SESSION["erreurs"] ?? [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Formulaire de contact</title>
</head>
<body>
  <main>
    <div class="container mt-5">
      <h2>Formulaire de Contact</h2>

      <form method="POST" action="traitement.php">

        <!-- NOM -->
        <div class="mb-3">
          <label for="nom" class="form-label">Nom :</label>
          <input type="text" name="nom" id="nom" class="form-control"
                 value="<?= htmlspecialchars($old['nom'] ?? '') ?>">
          <?php if (!empty($erreurs['nom'])): ?>
            <div class="text-danger"><?= $erreurs['nom'] ?></div>
          <?php endif; ?>
        </div>

        <!-- EMAIL -->
        <div class="mb-3">
          <label for="email" class="form-label">Email :</label>
          <input type="text" name="email" id="email" class="form-control"
                 value="<?= htmlspecialchars($old['email'] ?? '') ?>">
          <?php if (!empty($erreurs['email'])): ?>
            <div class="text-danger"><?= $erreurs['email'] ?></div>
          <?php endif; ?>
        </div>

        <!-- MESSAGE -->
        <div class="mb-3">
          <label for="message" class="form-label">Message :</label>
          <textarea name="message" id="message" class="form-control" rows="5"><?= htmlspecialchars($old['message'] ?? '') ?></textarea>
          <?php if (!empty($erreurs['message'])): ?>
            <div class="text-danger"><?= $erreurs['message'] ?></div>
          <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
      </form>
    </div>
  </main>
</body>
</html>

<?php
// On vide les erreurs après affichage
unset($_SESSION["erreurs"], $_SESSION["old"]);
?>
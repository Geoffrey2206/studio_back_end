<?php require_once __DIR__ . '/../../../functions/fonctions.php'; // ou chemin relatif correct ?>
<form action="traitement_upload_photo.php" method="POST" enctype="multipart/form-data">
    <label for="photo">Choisir une photo :</label><br>
    <input type="file" name="photo" id="photo" accept="image/*" required><br><br>
    <input type="submit" value="Mettre à jour ma photo">
</form>

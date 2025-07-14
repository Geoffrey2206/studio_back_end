<?php foreach($ateliers as $atelier): ?>
<div class="col-xl-3 col-md-6 col-sm-6">
    <img src="<?= $atelier['image']; ?>" alt="<?= $atelier['alt']; ?>" class="img-fluid mb-3"/>
    <h3 class="fw-bold"><?= $atelier['titre']; ?></h3>
    <p><?= $atelier['texte']; ?></p>
</div>
<?php endforeach ?>

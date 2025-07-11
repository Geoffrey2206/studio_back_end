<?php foreach($actualities as $actuality): ?>
<div class="col-md-4">
    <div class="card border-0 h-100">
        <img src="<?= $actuality['image']; ?>" alt="<?= $actuality['alt']; ?>" class="news-image"/>
        <div class="d-flex flex-column">
            <p class="my-2"><?= $actuality['date']; ?></p>
            <h5 class="fw-bold"><?= $actuality['titre']; ?></h5>
            <p><?= $actuality['texte']; ?></p>
            <a href="<?= $actuality['lien']; ?>" class="btn-border-b-responsive anim-none-responsive mt-auto style-link">LIRE LA SUITE</a>
        </div>
    </div>
</div>
<?php endforeach; ?>  
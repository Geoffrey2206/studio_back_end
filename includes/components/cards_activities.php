<div class="row g-0">
    <?php foreach($activities as $activity): ?>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12 position-relative">
        <img src="<?= $activity['bg-image']?>" alt="<?= $activity['alt-image']?>" class="images w-100"/>
        <div class="overlay d-flex flex-column align-items-center justify-content-center">
            <img
                src="<?= $activity['icone']?>"
                alt="<?= $activity['alt-icone']?>"
            />
            <h5 class="text-white mb-2"><?= $activity['titre']?></h5>
            <p class="fw-light text-center"><?= $activity['texte']?></p>
            <a href="<?= $activity['lien']?>" target="_blank" class="mt-3 text-white btn-border-w-responsive underline-anim"> EN SAVOIR PLUS </a>
        </div>
    </div>
    <?php endforeach; ?>
</div>
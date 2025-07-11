<body>
    <section class="container my-5">
    <h1 class="mb-4">Nos articles</h1>
    <?php if (empty($articles)): ?>
        <p>Aucun article publié pour le moment.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($articles as $article): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow">
                        <div style="height: 200px; overflow: hidden;">
                            <picture>
                                <source srcset="<?= htmlspecialchars($article['img_thumbnail']) ?>" media="(max-width: 150px)">
                                <source srcset="<?= htmlspecialchars($article['img_small']) ?>" media="(max-width: 480px)">
                                <source srcset="<?= htmlspecialchars($article['img_medium']) ?>" media="(max-width: 768px)">
                                <source srcset="<?= htmlspecialchars($article['img_large']) ?>">
                                <img src="<?= htmlspecialchars($article['img_large']) ?>"
                                    alt="<?= htmlspecialchars($article['img_alt'] ?? '') ?>"
                                    class="w-100 h-100"
                                    style="object-fit: cover;">
                            </picture>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($article['title_article']) ?></h5>
                            <p class="card-text">
                                <?= mb_strimwidth(strip_tags($article['content_article']), 0, 100, '...') ?>
                            </p>
                            <a href="article.php?id=<?= $article['id_article'] ?>" class="btn btn-primary">Lire la suite</a>
                        </div>
                        <div class="card-footer text-muted small">
                            Par <?= htmlspecialchars($article['name_user'] . ' ' . $article['surname_user']) ?> -
                            le <?= date('d/m/Y', strtotime($article['created_at'])) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
</body>
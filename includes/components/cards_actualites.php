<?php foreach($articles as $article): ?>
<div class="col-md-4">
    <div class="card border-0 h-100 d-flex flex-column">
        <?php if (!empty($article['img_small'])): ?>
            <img src="<?= htmlspecialchars($article['img_small']); ?>"
                 alt="<?= htmlspecialchars($article['img_alt'] ?? 'Image article'); ?>"
                 class="news-image"/>
        <?php endif; ?>

        <div class="d-flex flex-column flex-grow-1 p-3">
            <p class="my-2"><?= date('d/m/Y', strtotime($article['created_at'])); ?></p>
            <h5 class="fw-bold"><?= htmlspecialchars($article['title_article']); ?></h5>
            <p> <?= mb_strimwidth(strip_tags(html_entity_decode($article['content_article'])), 0, 100, '...'); ?></p>
            <a href="blog.php#article-<?= $article['id_article']; ?>"
               class="btn-border-b-responsive anim-none-responsive mt-auto style-link">
               LIRE LA SUITE
            </a>
        </div>
    </div>
</div>
<?php endforeach; ?>  
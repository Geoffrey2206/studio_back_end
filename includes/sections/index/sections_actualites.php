<?php
// include __DIR__ . '../../../data.php';
include __DIR__ . '/../../../functions/fonctions.php';

$articles = getLastArticles(3);

?>
 <!-- ==========================================================================
         SECTION 3 - Actualités
         Description : Affichage des dernières actualités du studio
         ========================================================================== -->
<section class="py-5">
    <div class="container-lg mt-3">
            <h2 class="text-center">NOS DERNIÈRES ACTUALITÉS</h2>
        <div class="container text-center">
            <img src="./assets/img/bg_titre.jpg" class="mx-auto d-block" alt="barre sous-titre" />
        </div>
        <div class="row g-3 text-left mt-4">
            <?php include __DIR__ .'/../../components/cards_actualites.php' ?>
        </div>
    </div>
</section>    
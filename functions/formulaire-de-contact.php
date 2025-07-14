 <!-- Formulaire de contact -->
     
        <div class="col-lg-8 contact-form px-md-3 px-4 order-1 order-lg-2">
            <h3 class="text-md-start text-center">
                FORMULAIRE DE CONTACT
            </h3>
            <img
            class="mt-1 mb-5 d-block mx-auto mx-md-0"
            src="./assets/img/bg_titre.jpg"
            alt="barre sous-titre"
            />

            <!-- méthode POST meilleur niveau de sécurité et éviter l'exposition des données dans l'URL-->
            <!-- attribut action traitement fictif -->
                <!-- jeton CSRF (Cross-Site Request Forgery) limite les attaques de type contrefaçon de requête -->
            <?php if (!empty($success)) : ?>
              <div class="alert alert-success">
                  <?= htmlspecialchars($success); ?>
              </div>
            <?php endif; ?>
            <form
            method="POST"
            action="traitement.php" class="needs-validation" novalidate>

            <div class="row mb-3">
              <div class="col-md-6 mb-3 mb-md-0">
                <input
                  type="text"
                  class="form-control"
                  placeholder="VOTRE NOM"
                  id="nom"
                  name="nom" required
                  value="<?= htmlspecialchars($old['nom'] ?? '')?>"
                />
                <?php if (isset($erreurs['nom'])) : ?>
                <div class="text-danger">
                  <?= htmlspecialchars($erreurs['nom']) ?>
                </div>
                <?php endif; ?>
              </div>
              <div class="col-md-6">
                <input
                  type="text"
                  class="form-control"
                  placeholder="VOTRE PRÉNOM"
                  id="prenom"
                  name="prenom" required
                  value="<?= htmlspecialchars($old['prenom'] ?? '')?>"
                />
                <?php if (isset($erreurs['prenom'])) : ?>
                <div class="text-danger">
                  <?= htmlspecialchars($erreurs['prenom']) ?>
                </div>
                <?php endif; ?>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6 mb-3 mb-md-0">
                <input
                  type="tel"
                  class="form-control"
                  placeholder="VOTRE TÉLÉPHONE"
                  id="tel"
                  name="tel" required
                  value="<?= htmlspecialchars($old['tel'] ?? '')?>"
                />
                <?php if (isset($erreurs['tel'])) : ?>
                <div class="text-danger">
                  <?= htmlspecialchars($erreurs['tel']) ?>
                </div>
                <?php endif; ?>
              </div>
              <div class="col-md-6">
                <input
                  type="email"
                  class="form-control"
                  placeholder="VOTRE EMAIL"
                  id="email"
                  name="email" required
                  value="<?= htmlspecialchars($old['email'] ?? '')?>"
                />
                <?php if (isset($erreurs['email'])) : ?>
                <div class="text-danger">
                  <?= htmlspecialchars($erreurs['email']) ?>
                </div>
                <?php endif; ?>
              </div>
            </div>
            <div class="mb-3">
              <input type="text" class="form-control" placeholder="SUJET" 
              id="sujet"
              name="sujet" required
              value="<?= htmlspecialchars($old['sujet'] ?? '')?>"
              />
              <?php if (isset($erreurs['sujet'])) : ?>
                <div class="text-danger">
                  <?= htmlspecialchars($erreurs['sujet']) ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
              <textarea
                class="form-control"
                rows="5"
                placeholder="VOTRE MESSAGE"
                id="msg"
                name="msg" required
                ><?= htmlspecialchars($old['msg'] ?? '')?></textarea>
                
            </div>
            <div class="text-center text-md-start">
                <button type="submit" class="btn mb-5">ENVOYER</button>
               <!-- Message de confirmation : Masqué par défaut -->
            <div class="confirmation-message d-none text-center text-md-start mt-3">
            Votre message a été envoyé !
            </div>
        </div>
    </form>
</div>
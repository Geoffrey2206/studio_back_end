<!----------------- Modals ----------------------------> 
<!-- ----------------------------------------------- -->

    <!-- Modal Création Utilisateur -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="create-user-form">
            <?= getCSRFTokenField(); ?>
            <input type="hidden" name="create_user" value="1">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Créer un nouvel utilisateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Prénom</label>
                        <input type="text" name="name_user" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Nom</label>
                        <input type="text" name="surname_user" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email_user" class="form-control" required>
                    </div> 
                    <div class="mb-3">
                        <label for="create-password" class="form-label">Mot de passe</label>
                        <div class="input-group">
                            <input type="text" name="password_user" class="form-control" id="create-password" required>
                            <button type="button" class="btn btn-outline-secondary" id="generate-password">Générer</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Rôle</label>
                        <select name="role_user" class="form-control">
                        <option value="Utilisateur">Utilisateur</option>
                        <option value="Modérateur">Modérateur</option>
                        <option value="Administrateur">Administrateur</option>               
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Statut</label>
                        <select name="status_user" class="form-control">
                        <option value="actif">Actif</option>
                        <option value="inactif">Inactif</option>
                        <option value="suspendu">Suspendu</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Créer</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                    Confirmer la suppression
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger">
                    <i class="fas fa-trash me-1"></i>
                    Supprimer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- modal de réponse aux messages - message contact -->
<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="replyForm" action="traitement_reponse.php" method="POST">
      <?= getCSRFTokenField(); ?>  
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="replyModalLabel">Répondre au message</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_contact" id="replyId">
          <input type="hidden" name="send_email" value="1">
          <div class="mb-3">
            <label for="replyText" class="form-label">Votre réponse :</label>
            <textarea name="reponse" id="replyText" class="form-control" rows="6" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Envoyer</button>
        </div>
      </div>
    </form>
  </div>
</div>

    <!--Modal pour affichage des messages -->
<div class="modal fade" id="viewMessageModal" tabindex="-1" aria-labelledby="viewMessageLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewMessageLabel"><i class="fas fa-envelope-open-text me-2"></i>Détail du message</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body bg-light">
                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="fas fa-user me-1"></i>Expéditeur :</label>
                        <p class="form-control-plaintext ps-2" id="modalFullName"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="fas fa-calendar-alt me-1"></i>Date :</label>
                        <p class="form-control-plaintext ps-2" id="modalDate"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="fas fa-tag me-1"></i>Sujet :</label>
                        <p class="form-control-plaintext ps-2" id="modalSubject"></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="fas fa-comment-alt me-1"></i>Message :</label>
                        <div class="p-3 bg-white rounded border shadow-sm" id="modalContent" style="white-space: pre-wrap;"></div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label for="replyMessage" class="form-label fw-bold"><i class="fas fa-reply me-1"></i>Réponse (bientôt)</label>
                        <textarea class="form-control bg-secondary bg-opacity-10 border-0 text-muted" id="replyMessage" rows="4" placeholder="Vous pourrez répondre ici plus tard..." disabled></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
    </div>
</div>

<!-- ✅ Modal de modification utilisateur -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form id="edit-user-form" method="POST">
      <?= getCSRFTokenField(); ?>
      <div class="modal-content shadow-lg border-0">
        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title" id="editModalLabel"><i class="fas fa-user-edit me-2"></i>Modifier l'utilisateur</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body bg-light">
          <input type="hidden" name="id_user" id="edit-id">

          <div class="mb-3">
            <label for="edit-name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="edit-name" name="name_user" required>
          </div>

          <div class="mb-3">
            <label for="edit-surname" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="edit-surname" name="surname_user" required>
          </div>

          <div class="mb-3">
            <label for="edit-email" class="form-label">Email</label>
            <input type="email" class="form-control" id="edit-email" name="email_user" required>
          </div>

          <div class="mb-3">
            <label for="edit-role" class="form-label">Rôle</label>
            <select class="form-select" id="edit-role" name="role_user">
              <option value="Administrateur">Administrateur</option>
              <option value="Modérateur">Modérateur</option>
              <option value="Utilisateur">Utilisateur</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="edit-status" class="form-label">Statut</label>
            <select class="form-select" id="edit-status" name="status_user">
              <option value="actif">Actif</option>
              <option value="inactif">Inactif</option>
              <option value="suspendu">Suspendu</option>
            </select>
          </div>
        </div>
        <div class="modal-footer bg-white">
          <button type="submit" class="btn btn-warning">Mettre à jour</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- MODALE DE CRÉATION / ÉDITION ARTICLE -->
<div class="modal fade" id="articleModal" tabindex="-1" aria-labelledby="articleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form id="articleForm" method="POST" action="functions/traitement_article.php" enctype="multipart/form-data">
      
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="articleModalLabel">Créer un article</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="article_id" id="article_id">
          <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
          <input type="hidden" name="statut" id="statut" value="brouillon">

          <!-- Titre -->
          <div class="mb-3">
            <label for="titre" class="form-label">Titre de l'article</label>
            <input type="text" class="form-control" id="titre" name="titre" required>
          </div>

          <!-- Contenu -->
          <div class="mb-3">
            <label for="contenu" class="form-label">Contenu</label>
            <textarea id="contenu" name="contenu" rows="10" class="form-control"></textarea>
          </div>

          <!-- Image -->
          <div class="mb-3">
            <label for="image" class="form-label">Image principale</label>
            <input type="file" class="form-control" id="image" name="image" accept=".jpg,.jpeg,.png">
            <!-- 📸 Zone pour afficher l'image actuelle -->
            <div id="current-image-preview" class="mt-3"></div>
          </div>
        </div>
        <!-- input pour gérer le descriptif image -->
        <div class="mb-3">
          <label for="img_alt" class="form-label">Description de l’image (attribut alt)</label>
          <input type="text" class="form-control" id="img_alt" name="img_alt" maxlength="255">
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-secondary" onclick="document.getElementById('statut').value='brouillon'">
            Enregistrer comme brouillon
          </button>

          <button type="submit" class="btn btn-success" onclick="document.getElementById('statut').value='publie'">
            Publier l'article
          </button>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Annuler
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
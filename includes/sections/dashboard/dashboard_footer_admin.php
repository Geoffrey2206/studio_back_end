<?php require_once __DIR__ . '/../../../functions/fonctions.php'; // ou chemin relatif correct ?>
<?php $page = $_GET['page'] ?? 'content'; ?>
<?php if (isset($_GET['page']) && $_GET['page'] === 'users'): ?>
  <script src="js/dashboard_user.js"></script>
<?php endif; ?>

<?php if (isset($_GET['page']) && $_GET['page'] === 'contacts'): ?>
  <script src="js/dashboard_contact.js"></script>
<?php endif; ?>
<!-- appelle de mon script article.js pour la page articles uniquement -->
<?php if (isset($_GET['page']) && $_GET['page'] === 'articles'): ?>
  <script src="js/dashboard_articles.js"></script>
<?php endif; ?>
<!-- <script src="js/dashboard.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<!-- appelle de la cdn TinyMCE -->
<script src="https://cdn.tiny.cloud/1/bj4fkwpds8gal4fmip12pfs9zwd658qq21t9729ncvgy8vah/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<!-- inclusion de jquery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>

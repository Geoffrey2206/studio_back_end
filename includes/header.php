<?php 
if(!isset($page)) {
    $page = basename($_SERVER['PHP_SELF'], '.php' );
 } 
 ?>
<!DOCTYPE html>
<html lang="fr">
  <!-- ==========================================================================
       HEAD - Métadonnées, styles et scripts
       Description : Contient les métadonnées, liens CSS/JS et polices
       ========================================================================== -->
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
      rel="stylesheet"
    />

    <!-- Bootstrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <!-- Awesome  -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    />

    <!-- Custom CSS et Favicon -->
    <link rel="apple-touch-icon" href="./assets/img/favicon.png" />
    <link rel="icon" href="./assets/img/favicon.png" type="image/png" />
    <link rel="stylesheet" href="./css/style-header-footer.css" />
    <?php if($page === "indexv2") : ?>
    <link rel="stylesheet" href="./css/style-accueil.css" />
    <?php elseif($page === "presentationv2") : ?>
    <link rel="stylesheet" href="./css/style-presentation.css" />  
    <?php elseif($page ==="contactv2") : ?>
    <link rel="stylesheet" href="./css/style-contact.css" />
    <?php elseif($page === "404v2") : ?>
    <link rel="stylesheet" href="./css/style-404.css" />
    <?php elseif($page === "blog") : ?>
    <link rel="stylesheet" href="./css/style-blog.css" />
    <?php elseif($page === "article") : ?>
    <link rel="stylesheet" href="./css/style-article.css" />
    <?php elseif($page === "inscription" || $page === "connexion"|| $page === "login") : ?>
    <link rel="stylesheet" href="./css/style-inscriptions.css" />
    <?php endif; ?>
    

    <!-- partager le lien sur les réseaux sociaux -->
  <meta property="og:title" content="Accueil - Studio Sport & Coaching" /><!-- 
    og = Open Graph 
    Définit le titre qui apparaîtra sur la carte de prévisualisation du lien.
    Exemple : Quand quelqu’un partage ton lien sur Facebook, ce titre apparaîtra en grand.
    --> 
  <meta property="og:description" content="Bienvenue sur le site officiel de Studio Sport & Coaching à Biarritz. Découvrez nos services et notre équipe." />
  <meta property="og:image" content="./assets/img/logo.png" />
  <meta property="og:type" content="website" />

  <!-- Balises SEO 
     Ces balises sont lues par les moteurs de recherche pour indexer ton site et afficher des informations pertinentes dans les résultats
    -->
  <meta name="description" content="Studio Sport & Coaching vous accueille à Biarritz pour des séances de sport personnalisées. Découvrez nos services et prenez rendez-vous." />
  <meta name="keywords" content="sport Biarritz, studio coaching, entraînement personnalisé, bien-être, coach sportif" />
  <meta name="author" content="Studio Sport & Coaching" />

    <title><?= $pageTitle ?? "LE STUDIO"?></title>
  </head>

  <body>
    <!-- ==========================================================================
         HEADER - Navigation et Carrousel
         Description : Contient la barre de navigation et le carrousel principal
         ========================================================================== -->
    <header>
        <nav
        class="navbar navbar-expand-lg bg-transparent position-absolute z-2 w-100 navins"
        >
        <div class="container-fluid menu-logo p-0">
          <a class="navbar-brand m-0" href="./indexv2.php">
            <img src="./assets/img/logo.png" class="logo" alt="Logo Le studio" />
          </a>

          <button
            class="navbar-toggler me-3 custom-toggler d-flex align-items-center gap-2 font-oswald"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="language-badge-inside">
              <span class="language-text">EN</span>
            </span>
            <i class="fa-solid fa-bars"></i>
          </button>

          <div
            class="collapse navbar-collapse justify-content-center"
            id="navbarNavDropdown"
          >
            <ul class="navbar-nav color-menu font-oswald">
              <li class="nav-item hover-menu">
                <a class="nav-link" aria-current="page" href="./404v2.php"
                  >L'EQUIPE</a
                >
              </li>

              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle hover-menu"
                  href="#"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  LES ACTIVITÉS
                </a>
                <ul class="dropdown-menu bg-black z-3 px-2">
                  <li>
                    <a
                      class="dropdown-item text-white hover-dropdown ps-3-responsive"
                      href="./404v2.php"
                    >
                      LE CYCLING
                    </a>
                  </li>
                  <li>
                    <a
                      class="dropdown-item text-white hover-dropdown ps-3-responsive"
                      href="./presentationv2.php"
                    >
                      LE TRAINING FONCTIONNEL
                    </a>
                  </li>
                  <li>
                    <a
                      class="dropdown-item text-white hover-dropdown ps-3-responsive"
                      href="./404v2.php"
                    >
                      LE CROSSFIT
                    </a>
                  </li>
                  <li>
                    <a
                      class="dropdown-item text-white hover-dropdown ps-3-responsive"
                      href="./404v2.php"
                    >
                      PERSONAL TRAINING - COACH PERSONNEL
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item hover-menu">
                <a class="nav-link" href="./404v2.php">NOS OFFRES</a>
              </li>
              <li class="nav-item hover-menu">
                <a class="nav-link" href="./404v2.php">PLANNING</a>
              </li>
              <li class="nav-item hover-menu">
                <a class="nav-link" href="./blog.php">BLOG</a>
              </li>
              <li class="nav-item hover-menu">
                <a class="nav-link" href="./contactv2.php">CONTACT</a>
              </li>
              <li class="nav-item hover-menu">
                <a class="nav-link" href="./inscription.php">INSCRIPTION</a>
              </li>

              <li class="nav-item d-flex align-items-center mx-lg-1">
                <a
                  class="nav-link d-flex align-items-center justify-content-center gap-2 me-2"
                  href="#"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-phone"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"
                    />
                    <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                  </svg>
                  05.59.47.84.18
                </a>
              </li>
              <li
                class="nav-item d-flex justify-content-center p-0 align-items-center gap-1"
              >
                <a
                  href="https://www.facebook.com"
                  class="icon fhover"
                  aria-label="Facebook"
                  target="_blank"
                ></a>
                <a
                  href="https://www.instagram.com"
                  class="icon ihover"
                  aria-label="Instagram"
                  target="_blank"
                ></a>
                <a
                  href="https://www.tripadvisor.fr"
                  class="icon thover"
                  aria-label="Tripadvisor"
                  target="_blank"
                ></a>
              </li>
              <li class="language-badge d-none d-lg-block mx-3">
                <a href="#" class="language-text" aria-label="Changer la langue en anglais">EN</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

<?php include __DIR__ . '/../functions/banner_switch.php'; ?>

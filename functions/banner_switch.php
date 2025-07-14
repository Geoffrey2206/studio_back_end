<?php
switch ($page) {
    case 'index' : 
    case 'indexv2' : 
        include __DIR__ . '/../functions/carousel_banner.php';
        break;
    
    case 'presentation' :
    case 'presentationv2' : 
        echo '      
        <div class="position-relative">
        <div class="w-100 position-relative">
          <div
            class="position-absolute top-0 start-0 w-100 h-100 overlay-banner"
          ></div>
          <img
            src="./assets/img/visuel/visuel_3.jpg"
            alt="Training Fonctionnel"
            class="img-fluid w-100 image-banner"
          />
        </div>
      </div>
    </header>';
    break;

    case 'contact' :
    case 'contactv2' :
        echo '
        <div class="position-relative">
        <div class="banner-img">
          <div
            class="position-absolute top-0 start-0 w-100 h-100"
            style="background-color: #000000; opacity: 0.6"
          ></div>
          <img
            src="./assets/img/visuel/header-contact.jpg"
            alt="Training Fonctionnel"/>
        </div>
      </div>
    </header>';
    break;
    case 'blog' :
    case 'blog' :
        echo '
        <div class="position-relative">
        <div class="banner-img">
          <div
            class="position-absolute top-0 start-0 w-100 h-100"
            style="background-color: #000000; opacity: 0.6"
          ></div>
          <img
            src="./assets/img/visuel/header-contact.jpg"
            alt="Training Fonctionnel"/>
        </div>
      </div>
    </header>';
    break;
    case 'article' :
    case 'article' :
        echo '
        <div class="position-relative">
        <div class="banner-img">
          <div
            class="position-absolute top-0 start-0 w-100 h-100"
            style="background-color: #000000; opacity: 0.6"
          ></div>
          <img
            src="./assets/img/visuel/header-contact.jpg"
            alt="Training Fonctionnel"/>
        </div>
      </div>
    </header>';
    break;
} 
?>
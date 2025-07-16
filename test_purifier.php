
<?php
require_once 'functions/fonctions.php';

$source = 'uploads/articles/1752230988_news1.jpg';
$dest = 'uploads/articles/test_thumb.jpg';

if (resizeImage($source, $dest, 150, 150)) {
    echo "✅ Redimensionnement réussi<br>";
} else {
    echo "❌ Redimensionnement échoué<br>";
}
?>
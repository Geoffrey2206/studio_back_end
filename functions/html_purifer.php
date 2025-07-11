<?php
require_once __DIR__ . '/../vendor/autoload.php';

function getPurifier(): HTMLPurifier {
    // static --> permet de ne pas recharger le même objet plusieurs fois
    static $purifier = null;

    if ($purifier === null) {
        $config = HTMLPurifier_Config::createDefault();

        // 🔥 Configuration étendue pour TinyMCE
        $config->set('HTML.Allowed', 
            'p,b,strong,i,em,u,a[href|title|target],ul,ol,li,br,' .
            'img[src|alt|width|height|style],' .
            'h1,h2,h3,h4,h5,h6,' .
            'blockquote,div[class],span[style],' .
            'table,thead,tbody,tr,td,th,' .
            'pre,code'
        );
        
        // 🔥 Autoriser les styles CSS basiques
        $config->set('CSS.AllowedProperties', 'text-align,width,height,margin,padding,color,background-color');
        
        // 🔥 Protocoles autorisés
        $config->set('URI.AllowedSchemes', [
            'http' => true, 
            'https' => true,
            'data' => true  // Pour les images base64 de TinyMCE
        ]);
        
        // 🔥 Créer le dossier cache s'il n'existe pas
        $cacheDir = __DIR__ . '/../cache';
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }
        $config->set('Cache.SerializerPath', $cacheDir);

        $purifier = new HTMLPurifier($config);
    }

    return $purifier;
}

// 🔥 Fonction helper pour nettoyer rapidement
function cleanHtml($html) {
    return getPurifier()->purify($html);
}
?>
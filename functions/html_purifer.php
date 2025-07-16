<?php
require_once __DIR__ . '/../vendor/autoload.php';

function getPurifier(): HTMLPurifier {
    static $purifier = null;

    if ($purifier === null) {
        $config = HTMLPurifier_Config::createDefault();

        $config->set('HTML.Allowed', 
            'p,b,strong,i,em,u,a[href|title|target],ul,ol,li,br,' .
            'img[src|alt|width|height|style],' .
            'h1,h2,h3,h4,h5,h6,' .
            'blockquote,div[class],span[style],' .
            'table,thead,tbody,tr,td,th,' .
            'pre,code'
        );
        
        $config->set('HTML.ForbiddenElements', 'script,object,embed,applet,iframe,form,input,button');
        $config->set('HTML.ForbiddenAttributes', 'onclick,onload,onerror,onmouseover,onfocus,onblur,onchange,onsubmit');
        
        $config->set('CSS.AllowedProperties', 'text-align,width,height,margin,padding,color,background-color');
        
        $config->set('URI.AllowedSchemes', [
            'http' => true, 
            'https' => true,
            'data' => true
        ]);
        
        $cacheDir = __DIR__ . '/../cache';
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }
        $config->set('Cache.SerializerPath', $cacheDir);

        $purifier = new HTMLPurifier($config);
    }

    return $purifier;
}

// ✅ CORRECTION : Décoder le HTML avant purification
function cleanHtml($html) {
    if (empty($html)) return '';
    
    // Décoder les entités HTML d'abord
    $html = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    
    return getPurifier()->purify($html);
}
?>
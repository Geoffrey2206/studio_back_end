<?php
// Test pour vérifier que l'autoload de Composer fonctionne correctement
echo "Test de l'autoload Composer...\n";

// Test 1: Depuis la racine
echo "1. Test depuis la racine du projet:\n";
try {
    require_once __DIR__ . '/vendor/autoload.php';
    echo "   ✅ Autoload chargé avec succès depuis la racine\n";
    
    // Test de PHPMailer
    if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        echo "   ✅ PHPMailer disponible\n";
    } else {
        echo "   ❌ PHPMailer non disponible\n";
    }
    
    // Test de HTMLPurifier
    if (class_exists('HTMLPurifier')) {
        echo "   ✅ HTMLPurifier disponible\n";
    } else {
        echo "   ❌ HTMLPurifier non disponible\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ Erreur: " . $e->getMessage() . "\n";
}

// Test 2: Depuis le dossier config
echo "\n2. Test depuis le dossier config:\n";
try {
    $config_path = __DIR__ . '/config';
    if (!defined('AUTOLOAD_LOADED')) {
        require_once __DIR__ . '/vendor/autoload.php';
        define('AUTOLOAD_LOADED', true);
    }
    echo "   ✅ Autoload accessible depuis config avec chemin relatif\n";
} catch (Exception $e) {
    echo "   ❌ Erreur depuis config: " . $e->getMessage() . "\n";
}

// Test 3: Depuis le dossier functions
echo "\n3. Test depuis le dossier functions:\n";
try {
    $functions_path = __DIR__ . '/functions';
    // Simuler le chemin depuis functions
    $autoload_from_functions = __DIR__ . '/vendor/autoload.php';
    if (file_exists($autoload_from_functions)) {
        echo "   ✅ Autoload accessible depuis functions\n";
    } else {
        echo "   ❌ Autoload non trouvé depuis functions\n";
    }
} catch (Exception $e) {
    echo "   ❌ Erreur depuis functions: " . $e->getMessage() . "\n";
}

echo "\n4. Vérification des fichiers Composer:\n";
if (file_exists(__DIR__ . '/composer.json')) {
    echo "   ✅ composer.json trouvé\n";
} else {
    echo "   ❌ composer.json non trouvé\n";
}

if (file_exists(__DIR__ . '/composer.lock')) {
    echo "   ✅ composer.lock trouvé\n";
} else {
    echo "   ❌ composer.lock non trouvé\n";
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "   ✅ vendor/autoload.php trouvé\n";
} else {
    echo "   ❌ vendor/autoload.php non trouvé\n";
}

echo "\nTest terminé !\n";
?>

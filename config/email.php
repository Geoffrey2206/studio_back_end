<?php
// Configuration email centralisée

return [
    // Paramètres SMTP Mailtrap
    'smtp_host' => 'sandbox.smtp.mailtrap.io',
    'smtp_port' => 587,
    'smtp_username' => '2e34d2b6eec8ad',
    'smtp_password' => '5bdf3a59ec17be',
    'smtp_secure' => 'tls',
    
    // Paramètres par défaut
    'from_email' => 'contact@monsite.com',
    'from_name' => 'Mon Site Web',
    'admin_email' => 'admin@monsite.com',
    'admin_name' => 'Administrateur',
    
    // Options
    'charset' => 'UTF-8',
    'debug' => false, // Mettre false en production
];
?>
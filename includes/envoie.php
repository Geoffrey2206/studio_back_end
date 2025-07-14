<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Envoie un email via Mailtrap
 * 
 * @param array $data Données du formulaire
 * @return array Résultat de l'envoi
 */
function envoyerEmail($data) {
    // Chargement de la configuration
    $config = require __DIR__ . '/../config/email.php';
    
    try {
        // Création de l'instance PHPMailer
        $mail = new PHPMailer(true);
        
        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host = $config['smtp_host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['smtp_username'];
        $mail->Password = $config['smtp_password'];
        $mail->SMTPSecure = $config['smtp_secure'];
        $mail->Port = $config['smtp_port'];
        $mail->CharSet = $config['charset'];
        
        // Debug (optionnel)
        if ($config['debug']) {
            $mail->SMTPDebug = 0; // 0 = off, 1 = client, 2 = client + server
        }
        
        // Expéditeur (email du formulaire)
        $mail->setFrom($config['from_email'], $config['from_name']);
        $mail->addReplyTo($data['email'], $data['nom']);
        
        // Destinataire (votre email)
        $mail->addAddress($config['admin_email'], $config['admin_name']);
        
        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = 'Nouveau message de contact - ' . $data['nom'];
        
        // Corps de l'email en HTML
        $mail->Body = genererCorpsEmail($data);
        
        // Version texte (optionnel mais recommandé)
        $mail->AltBody = genererCorpsEmailTexte($data);
        
        // Envoi
        $mail->send();
        
        return [
            'success' => true,
            'message' => 'Email envoyé avec succès !'
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Erreur lors de l\'envoi : ' . $e->getMessage()
        ];
    }
}

/**
 * Génère le corps de l'email en HTML
 */
function genererCorpsEmail($data) {
    $html = '
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: #f4f4f4; padding: 20px; text-align: center; }
            .content { padding: 20px; }
            .info { background: #e9ecef; padding: 15px; margin: 10px 0; }
            .footer { text-align: center; font-size: 12px; color: #666; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Nouveau Message de Contact</h1>
            </div>
            
            <div class="content">
                <div class="info">
                    <strong>Nom :</strong> ' . htmlspecialchars($data['nom']) . '
                </div>
                
                <div class="info">
                    <strong>Email :</strong> ' . htmlspecialchars($data['email']) . '
                </div>
                
                <div class="info">
                    <strong>Date :</strong> ' . date('d/m/Y à H:i') . '
                </div>
                
                <div class="info">
                    <strong>Message :</strong><br>
                    ' . nl2br(htmlspecialchars($data['msg'])) . '
                </div>
            </div>
            
            <div class="footer">
                <p>Email envoyé depuis votre site web</p>
            </div>
        </div>
    </body>
    </html>';
    
    return $html;
}

/**
 * Génère le corps de l'email en texte brut
 */
function genererCorpsEmailTexte($data) {
    return "NOUVEAU MESSAGE DE CONTACT\n\n" .
           "Nom: " . $data['nom'] . "\n" .
           "Email: " . $data['email'] . "\n" .
           "Date: " . date('d/m/Y à H:i') . "\n\n" .
           "Message:\n" . $data['msg'] . "\n\n" .
           "---\nEmail envoyé depuis votre site web";
}

function envoyerReponse($email, $reponse) {
   $mail = new PHPMailer(true);
    try {
        $mail->setFrom('contact@lestudio.com', 'Gérant / Le studio GYMS');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Réponse à votre message';
        $mail->Body = nl2br(htmlspecialchars($reponse));
        $mail->AltBody = $reponse;
        $mail->send();
        return ['success' => true];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $mail->ErrorInfo];
    }
}
// fonction pour l'envoie de mail automatiqueemnt apres réponse de l'administrateur depuis le dashboard - contact message.
function envoyerReponseAvecSMTP($email, $reponse) {
    $config = require __DIR__ . '/../config/email.php';

    $mail = new PHPMailer(true);
    try {
        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host = $config['smtp_host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['smtp_username'];
        $mail->Password = $config['smtp_password'];
        $mail->SMTPSecure = $config['smtp_secure'];
        $mail->Port = $config['smtp_port'];
        $mail->CharSet = $config['charset'];

        if ($config['debug']) {
            $mail->SMTPDebug = 2;
        }

        // Expéditeur et destinataire
        $mail->setFrom($config['from_email'], 'Le Studio GYMS');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Réponse à votre message';
        $mail->Body = "<p>Bonjour,</p><p>Voici notre réponse à votre message :</p><blockquote>$reponse</blockquote>";
        $mail->AltBody = $reponse;

        $mail->send();
        return ['success' => true];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $mail->ErrorInfo];
    }
}
?>
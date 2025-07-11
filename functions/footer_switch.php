<?php
switch ($page) {
    case 'index' : 
    case 'indexv2' : 
        include __DIR__ . '/../includes/components/footer/partenaires.php';
    break;

    case 'presentation' : 
    case 'presentationv2' : 
        include __DIR__ . '/../includes/components/footer/activity.php';
    break;

    case 'contact' : 
    case 'contactv2' : 
        include __DIR__ . '/../includes/components/footer/map.php';
    break;
}
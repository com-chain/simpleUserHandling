<?php

function getServerName(){
    return "<monnaie-com-chain>";
}



function doSendMailOnInsert(){
    return false;
}

function getMailSubject(){
  return 'Vos information pour <Nom Monnaie>';
}

function getMailText($nom,$prenom,$code){
    return 'Bonjour '.$prenom.' '.$nom.',%0A%0A
Voici les informations dont vous aurez besoin pour <Nom Monnaie>.%0A %0A

Meilleures salutations%0A
Votre équipe <Nom Monnaie>%0A%0A

Liens vers votre votre lettre de bienvenue:%0A
https://<monnaie.org>/pdf.php?id='.$code.'&nom='.$prenom.' '.$nom.'
';
}

function getMailHeader(){
    return 'From: <user@monnaie.org>' . "\r\n" .
        'Reply-To: <user@monnaie.org>' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
}



?>

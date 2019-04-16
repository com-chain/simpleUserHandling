<?php
//include 'challange.php';

function writeHead() {
    echo '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./resources/admin.css" />
   <!-- 
     <script type="text/javascript">
    if (window.location.protocol == "http:") {
        var restOfUrl = window.location.href.substr(5);
        window.location = "https:" + restOfUrl;
    }
</script>-->
    <script>
        function toggleClass(element,class_name){
            var regex_1 = new RegExp(\'(?:^|\\\s)\'+class_name+\'(?!\\\S)\');
            if ( element.className.match(regex_1) ){
                 var regex_2 = new RegExp(\'(?:^|\\\s)\'+class_name+\'(?!\\\S)\',\'g\');
                 element.className = element.className.replace(regex_2, \'\' );
            } else {
                element.className += " "+class_name;
            }
        }
        
        
    </script>
</head>';
}

function writeHeader() {
    echo '
      <div class="hd" >
        <img class="logoBd-img" src="resources/wide-logo.png" alt="logo-allonge" />
        <span class="hd_title">Pages d\'administration</span>';
        
    
    if (isset($_SESSION['_UserId'])){
   
        echo '<span class="hd_title">Bonjour '.$_SESSION['_name'].'. Derni&egrave;re connection le '.$_SESSION['_ll'].'&nbsp;&nbsp;<a class="pgeBtn" href="./identification.php">Se D&eacute;connecter </a></span>';
    }
    
    echo'
    </div>
';
}



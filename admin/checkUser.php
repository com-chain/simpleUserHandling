<?php
  ob_start();
  session_name("Monnaie");
  session_start();
  header('Content-Type: text/html; charset=utf-8');
  
  if (!isset($_SESSION['_UserId']) || $_SESSION['_UserId']<=0 ){
    header('Location: login.php');
    exit();	
  }
  
  if ($_SESSION['_Access']==0){
     header('Location: login.php');
     exit();
  }
?>

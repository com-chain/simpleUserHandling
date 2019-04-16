<?php
include 'checkUser.php';
include 'db.php';

  $mail=$_POST['mail'];
  $psw    = $_POST["psw"]; 
  
  if (isset($_POST["da"])){  $da = 1 ; } else { $da = 0 ;}
  $uid    = $_POST["uid"];
  
  if (isset($_GET['d']) and isset($_GET['uid'])){
     $db->deleteUser($_GET['uid']);
  } else {

      if ($uid>0){
        $db->updateUser($uid, $da);
      } else {
    
        $db->insertUser($mail, $psw, $da);
      }
  }

  header('Location: ./admin.php');
  exit();
?>

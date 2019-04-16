<?php
      ob_start();
      session_name("Monnaie");	
      session_start(); 				
      if($_POST && !empty($_POST['login']) && !empty($_POST['mdp'])) {
         include 'db.php';
         $user_info = $db->getUserInfosfromEmail($_POST['login']);
        

         if (!isset($user_info["Id"])){
	        header('Location: login.php');
            exit();	
          }
          $password_md5 = md5($_POST['mdp'].$user_info["Salt"]); 
         // echo $password_md5; exit(); 
         //$db->updateUserPsw($user_info["Id"],$password_md5);
	     if(similar_text($password_md5, $user_info["Password"], $percent)==32){
	       $_SESSION['_UserId'] = $user_info["Id"];
	       $_SESSION['_name'] = $user_info["EMail"];
	       $_SESSION['_ll'] = $user_info["LastLoggedIn"];
	       $_SESSION['_Access'] = $user_info["IsAdmin"];
              
	       $user_info = $db->updatelastLogin($user_info["Id"]);

	       header('Location: ./start.php');
	       
	     } else {
	       header('Location: login.php');	 
	     }
     } else {
        // LogOut
	$_SESSION = array();
	if (ini_get("session.use_cookies")) {
	   $params = session_get_cookie_params();
	   setcookie(session_name(), '', time() - 42000,$params["path"], $params["domain"],$params["secure"], $params["httponly"]);
	}
	session_destroy();
        header('Location: login.php');
     }
     exit();	
?>




	

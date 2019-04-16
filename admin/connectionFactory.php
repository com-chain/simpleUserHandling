<?php 
class ConnectionFactory { 
        
    public static function GetConnection() { 
      date_default_timezone_set("UTC");
	  $mysqli = new mysqli("localhost","monnaie_db_user","<yourPassword>","monnaie_db");
	  if ($mysqli->connect_errno) {
		  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	  }
	  
	  if (!$mysqli->set_charset("utf8")) {
        printf("Erreur lors du chargement du jeu de caractères utf8 : %s\n", $mysqli->error);
     } 
	  
	  return $mysqli;  
    } 
} 
	
?> 



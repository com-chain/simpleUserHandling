<?php 
include 'connectionFactory.php';

  class MyLiteDB extends SQLite3 {
      function __construct() {
         $this->open('../membres.db');
      }
      
      function __destruct() {
         $this->close();
      }
      
      public function hasMember($code) {
        $sql ="SELECT Code from Membres where Code = '$code' ";   
        $ret = $this->query($sql);   
        $row = $ret->fetchArray(SQLITE3_ASSOC); 
        return $row["Code"]==$code;
      }
      
      public function insertMember($first,$last,$mail) {
        $addnom=$last;
        $addprenom=$first;
        $addemail=$mail;
        $code=md5($addnom . $addprenom);
        $sql ="INSERT INTO Membres(Id, Nom, Prenom, Email, Code, Count) values (\"$code\", \"$addnom\", \"$addprenom\", \"$addemail\", \"$code\", 0)";
        $ret = $this->query($sql);
        return  $code;
      }
      
      
      public function getList($filter_first,$filter_last) {
        $filter_prenom = $filter_first."%";
        $filter_nom = $filter_last."%";
        $sql ="SELECT * from Membres where Nom LIKE '$filter_nom' and Prenom LIKE '$filter_prenom' ";     
        $ret = $this->query($sql);
        $result = array();
        while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
            $sub = array("Nom"=>$row['Nom'], "Pernom"=>$row['Prenom'], "Email"=>$row['Email'] ,"Code"=>$row['Code'] );
            array_push($result,$sub);
        }
        
        return $result;
      } 
      
      public function getUserList(){
        $sql = "SELECT Id,EMail,LastLoggedIn,Salt,IsAdmin FROM MonnaieSiteUser";
        $ret = $this->query($sql);
        $result = array();
        while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
            $sub = array("id"=>$row['Id'], "email"=>$row['EMail'], "lastCo"=>$row['LastLoggedIn'] ,"salt"=>$row['Salt'],"isAdm"=>$row['IsAdmin']);
            array_push($result,$sub);
        }
        
        return $result;
      }
      
      public function getUserInfos($id){
         $sql = "SELECT Id,EMail,LastLoggedIn,Password, Salt,IsAdmin FROM MonnaieSiteUser WHERE Id=".$id;
         $ret = $this->query($sql);
         $row = $ret->fetchArray(SQLITE3_ASSOC);
         return $row;
      }
      
      public function getUserInfosfromEmail($email){
         $sql = "SELECT Id,EMail,LastLoggedIn,Password,Salt,IsAdmin FROM MonnaieSiteUser WHERE EMail='$email'";
         $ret = $this->query($sql);
         $row = $ret->fetchArray(SQLITE3_ASSOC);
         return $row;
      }
      
      public function updateUserPsw($id,$psw_hash){
         $sql = "Update  MonnaieSiteUser set Password='$psw_hash' WHERE Id =$id";
         $ret = $this->query($sql);
      }
      
      public function updatelastLogin($id){
         $sql = "Update  MonnaieSiteUser set LastLoggedIn=date('now') WHERE Id =$id";
         $ret = $this->query($sql);
      }
      
      public function insertUser($EMail,$Password,$IsAdmin){
          $salt   = date('Y-m-d:h:m:s');
          $password_md5 = md5($Password.$salt);
          $sql = "INSERT INTO MonnaieSiteUser (EMail,Salt,Password,IsAdmin) VALUES ('$EMail', '$salt', '$password_md5', $IsAdmin)";
          $ret = $this->query($sql);
      }
      
      public function updateUser($id,$isAdmin){
        $sql = "UPDATE MonnaieSiteUser SET IsAdmin=$isAdmin WHERE Id=$id";
         $ret = $this->query($sql);
      }
      
      public function deleteUser($id){
          $sql = "DELETE FROM MonnaieSiteUser WHERE Id=$id";
          $ret = $this->query($sql);
      }
      
      
      // For migration purpose
      public function createUserTable(){
        $sql ="CREATE TABLE  MonnaieSiteUser (Id INTEGER  PRIMARY KEY AUTOINCREMENT, CreatedOn TEXT DEFAULT CURRENT_TIMESTAMP , LastLoggedIn TEXT NULL , EMail TEXT NOT NULL , Salt TEXT NOT NULL , Password TEXT NOT NULL , IsAdmin INTEGER NOT NULL DEFAULT 0)"; 
        $ret = $this->query($sql);
        
        $sql ='INSERT INTO MonnaieSiteUser (EMail,Salt,Password,IsAdmin) VALUES("Admin_0","2019-02-08:09:02:43","e8fd6ac7a9374428896d7d09734e4ba1",1)';
        $ret = $this->query($sql);
      }
   }
   
   class MySqlDB {
   
     protected $mysqli = null; 
     
     function __construct() {
       $this->$mysqli =  ConnectionFactory::GetConnection();
      }
      
       public function hasMember($code) {
        $stmt = $this->$mysqli->prepare("SELECT Code from Membres where Code = ?");
        $stmt->bind_param("s",$code );
        $stmt->bind_result($rescode);
        $stmt->execute();
        $result = array();
        return $stmt->fetch();
      }
      
      
      public function insertMember($first,$last,$mail) {
        $addnom=$last;
        $addprenom=$first;
        $addemail=$mail;
        $code=md5($addnom . $addprenom);
        $stmt = $this->$mysqli->prepare("INSERT INTO MonnaieMembers(Nom, Prenom, EMail,Code) VALUES (?,?,?,?) ");
        $stmt->bind_param("ssss",$addnom,$addprenom,$addemail,$code );
        $stmt->execute();
        $stmt->close();
        return  $code;
      }
      
      
      public function getList($filter_first,$filter_last) {
         $stmt = $this->$mysqli->prepare("SELECT Nom, Prenom, EMail,Code FROM MonnaieMembers WHERE Nom LIKE ? AND Prenom LIKE ?");
         $filter_nom = $filter_first."%";
         $filter_prenom = $filter_last."%";
         $stmt->bind_param("ss",$filter_nom,$filter_prenom);
         $stmt->bind_result($nom,$prenom, $EMail,$code);
         $stmt->execute();
         $result = array();
         while ($stmt->fetch()){
            $sub = array("Nom"=>$nom, "Pernom"=>$prenom, "Email"=>$EMail ,"Code"=>$code );
            array_push($result,$sub);
         }
         return $result;
      } 
      
      public function getUserList(){
         $stmt = $this->$mysqli->prepare("SELECT Id,EMail,LastLoggedIn,Salt,IsAdmin FROM MonnaieSiteUser");
         $stmt->bind_result( $Id, $EMail,$last,$s, $IsAdmin);
         $stmt->execute();
         $result = array();
         while ($stmt->fetch()){
            $sub = array("id"=>$Id, "email"=>$EMail, "lastCo"=>$last ,"salt"=>$s, "isAdm"=>$IsAdmin );
            array_push($result,$sub);
         }
         return $result;
      }
      
      public function getUserInfos($id){
         $stmt =  $this->$mysqli->prepare("SELECT Id,EMail,LastLoggedIn,Password,Salt,IsAdmin FROM MonnaieSiteUser WHERE Id =?");
         $stmt->bind_param("i", $id );
         
         $stmt->bind_result( $Id, $EMail, $LastLoggedId,$Password, $Salt,$IsAdmin);
         $stmt->execute(); 
         $stmt->fetch();
         $stmt->close();
         
         return array("Id"=>$Id,"EMail"=>$EMail,"LastLoggedId"=>$LastLoggedId,"Password"=>$Password,"Salt"=>$Salt,"IsAdmin"=>$IsAdmin);
      }
      
      public function getUserInfosfromEmail($email){
         $stmt =  $this->$mysqli->prepare("SELECT Id,EMail,LastLoggedIn,Password,Salt,IsAdmin FROM MonnaieSiteUser WHERE EMail =?");
         $stmt->bind_param("s", $email );
         
         $stmt->bind_result( $Id, $EMail, $LastLoggedId,$Password, $Salt,$IsAdmin);
         $stmt->execute(); 
         $stmt->fetch();
         $stmt->close();
         
         return array("Id"=>$Id,"EMail"=>$EMail,"LastLoggedId"=>$LastLoggedId,"Password"=>$Password,"Salt"=>$Salt,"IsAdmin"=>$IsAdmin);
      
      }
      
      public function updateUserPsw($id,$psw_hash){
         $stmt =  $this->$mysqli->prepare("Update  MonnaieSiteUser set Password=? WHERE Id =?");
         $stmt->bind_param("si",$psw_hash ,$id );
	     $stmt->execute();
 	     $stmt->close();
      }
      
      public function updatelastLogin($id){
         $stmt = $this->$mysqli->prepare("Update  MonnaieSiteUser set LastLoggedIn=now() WHERE Id =?");
         $stmt->bind_param("i", $id );
	     $stmt->execute();
 	     $stmt->close();
      }
       
      public function deleteUser($id){
         $stmt = $this->$mysqli->prepare("DELETE FROM MonnaieSiteUser WHERE Id=?");
         $stmt->bind_param("i",$id );
         $stmt->execute();
         $stmt->close();
      }
     
      public function updateUser($id,$isAdmin){
         $stmt = $this->$mysqli->prepare("UPDATE MonnaieSiteUser SET IsAdmin=? WHERE Id=?");
         $stmt->bind_param("ii",$isAdmin,$id );
         $stmt->execute();
         $stmt->close();
      }
     
      public function insertUser($EMail,$Password,$IsAdmin){
          $salt   = date('Y-m-d:h:m:s');
          $password_md5 = md5($Password.$salt);
          $stmt = $this->$mysqli->prepare("INSERT  MonnaieSiteUser (EMail,Salt,Password,IsAdmin) VALUES (?,?,?,?)");
          $stmt->bind_param("sssi", $EMail, $salt, $password_md5, $IsAdmin);
          $stmt->execute();
          $stmt->close();
      }
    
   }
   
   
   $db = new MyLiteDB();
   // Usage 
   //  $db = new My**DB();
   //  $db->insertMember(...);
   //  $db->getList(...);
   

   
   ?>

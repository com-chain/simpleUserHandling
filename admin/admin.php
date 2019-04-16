<?php
include 'checkUser.php';
include '_commonBlock.php';
include 'db.php';

writeHead();

echo'<body>';
    
writeHeader();



 $pswError='';
  // change password
  if (isset($_POST['opsw']) || isset($_POST['npsw']) || isset($_POST['cnpsw'])){
    $user_info = $db->getUserInfos($_SESSION['_UserId']);
    $Password = $user_info["Password"];
    $Salt = $user_info["Salt"];
    $storedPasword = $Password;
    $opsw_md5 = md5($_POST['opsw'].$Salt);
    $npsw_md5 = md5($_POST['npsw'].$Salt);
    $cnpsw_md5 = md5($_POST['cnpsw'].$Salt);
    if (strlen ($_POST['npsw'])>5){
      if (similar_text($opsw_md5, $storedPasword, $percent)==32){
         if (similar_text($npsw_md5, $cnpsw_md5, $percent)==32){
           $db->updateUserPsw($_SESSION['_UserId'],$npsw_md5) ;
           $pswError= 'le mot de passe a &eacute;t&eacute; chang&eacute;.';
         } else{
           $pswError= 'Le nouveau mot de passe et sa confirmation ne correspondent pas.';
         }
      } else {
        $pswError= 'L\'ancien mot de passe est incorrecte.';
      }
   } else {
     $pswError= 'Le nouveau mot de passe est trop court (min 6 caract&egrave;res).';
   }
 }







echo' 
<div class="blk">
 <span class="blk_title"> Changer mon mot de passe</span> 
 
 
 <form action="./admin.php" method="post">
        <span class="c1_txt">Le mot de passe n\'est pas conserv&eacute; sous une forme lisible n&eacute;anmoins nous vous recommandons fortement d\'utiliser un mot de passe sp&eacute;cifique et de ne pas le r&eacute;utiliser ailleur. </span><br/><br/>

            <span class="form_item">
	            <span class="label">Ancien mot de passe :</span>
	            <input class="inputText"  type="password" name="opsw" />
	        </span><br/>
            <span class="form_item">
	            <span class="label">Nouveau mot de passe  :</span>
	            <input class="inputText"  type="password" name="npsw" />
	        </span><br/>
            <span class="form_item">
	            <span class="label">Nouveau mot de passe  :</span>
	            <input class="inputText"  type="password" name="cnpsw" />
	        </span><br/>
';
  if (strlen ($pswError)>0){
    echo '<span class="c1_txt"><span class="formMessage">'.$pswError.'</span></span><br/>';
  }
  echo'	   <span class="c1_txt"> 
                <span class="btnBar"> 
                  <input class="pgeBtn " type="submit" title="Changer"value="Changer"/> 
               </span>
           </span>    
        </form>
 
 
 
</div>

 <div class="blk">
       <span class="blk_title"> Gestion des utilisateurs  <a class="pgeBtn"  href="changeUser.php?id=0" title="Nouvel Utilisateur">Nouvel Utilisateur</a></span>
       
      <table class="wt t4"><tr class="tblHeader"><td >Identifiant</td><td>Derni&egrave;re connection</td>
      <td >Actif</td>
      <td >Action</td>
      </tr>';
      
      
      $list = $db->getUserList();
      foreach($list as $item) {

         $date='';
         if (isset( $item["lastCo"])){
           $d1=new DateTime( $item["lastCo"]);
           $date=$d1->format('d/m/Y');
         }
         echo' <tr ><td >'. $item["email"].'</td><td>'.$date.'</td>
          <td class="rt">'.$item["isAdm"].'</td>
          <td class="rt">';
         if($item["isAdm"]==0){
            echo' <a href="./addUser.php?uid='.$item["id"].'&d=1" class="gridButton" >Supprimer</a>';
         }
         
         echo'
         <a href="./changeUser.php?uid='.$item["id"].'" class="gridButton" >Modifier</a>
          </tr>';
     }
     
     echo '</table>
              </span>
              
              <span class="h_txt"> 
                <span class="form_btnBar right"> 
                   <a class="pgeBtn" href="start.php" title="Fermer" >Fermer</a>
               </span>
           </span>    
           </div>     
        </div>   
     </div>
</body>
</html>';
?>

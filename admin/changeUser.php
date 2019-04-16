<?php
include 'checkUser.php';

include '_commonBlock.php';

include 'db.php';
writeHead();

echo'<body>';
    
writeHeader();

	$isReadonly=0;
	$readonly='';
	$button='Cr&eacute;er';
	if ($_GET['uid']>0 ){
	  $isReadonly=1;
	  $readonly=' readonly="readonly" ';
	  $button='Modifier';
	  $user_info = $db->getUserInfos($_GET['uid']);
	} 
	
	 
    

echo ' <div class="blk">
       <span class="blk_title"> Utilisateur  </span>
       <form action="./addUser.php" method="post"> 
        <input type="hidden" name="uid" value="'.$user_info["Id"].'"/>
        <span class="form_item">
           <span class="label">Identifiant* :</span>
           <input type="text" name="mail" value="'.$user_info["EMail"].'" '.$readonly.' requiered/><br/>
        </span>';
           
if ($isReadonly==0){
   echo' 
          <span class="form_item">
                <span class="label">Mot de passe initial* :</span>
                <input type="text" name="psw" requiered/><br/>
          </span>';
}
echo'  
               <span class="form_item">
                    <span class="label">Utilisateur actif :</span>
                    <input type="checkbox" name="da" value="1" '; if ($user_info["IsAdmin"]==1) {echo 'checked="cheched"';} echo'/><br/>
               </span>
             
               <span class="form_btnBar right"> 
                    <a class="pgeBtn" href="admin.php" title="Annuler" >Annuler</a> <input class="pgeBtn" type="submit" value="'.$button.'" title="'.$button.'" /> 
               </span>
               
           </form>
            
          
     </div>
</body>
</html>';
?>  

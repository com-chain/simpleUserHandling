<?php
include 'checkUser.php';

include '_commonBlock.php';
include 'db.php';
include 'resources/const.php';

// For migrating old SQlite DB
// $db->createUserTable();
writeHead();

echo'<body>';
    
writeHeader();

function sendMail($to,$nom,$prenom,$code){
     $subject = getMailSubject();
     $message = getMailText($nom, $prenom, $code);
     $headers = getMailHeader();
     mail($to, $subject, $message, $headers);
}

  // edit membre
  
  if (isset($_GET['code']) && isset($_GET['editmail'])){
    $db->updateMember($_GET['code'],$_GET['editmail']);  
  } else 
  
  // Add membre
  
  if (isset($_GET['addnom']) && isset($_GET['addprenom'])) {
     $code = $db->insertMember($_GET['addprenom'],$_GET['addnom'],$_GET['addmail']);  
     
     if (doSendMailOnInsert()){
         sendMail($_GET['addmail'], $_GET['addnom'], $_GET['addprenom'], $code);
    }
  }
  
  
   if (isset($_GET['nom'])) {
          $snom = $_GET['nom'];
       } else if (isset($_GET['addnom'])){
          $snom = $_GET['addnom'];
       } else {
          $snom = '';
       }
       
       if (isset($_GET['prenom'])) {
          $sprenom = $_GET['prenom'];
       } else if (isset($_GET['addprenom'])){
          $sprenom = $_GET['addprenom'];
       } else {
          $sprenom = "";
       }
   

echo'
    <div class="blk">
       <span class="blk_title"> Gestion des comptes </span>
         <span class="form_btnBar"> 
           <a class="pgeBtn" href="https://wallet.cchosting.org/bureau/" target="_blanck">Acc&eacute;der au bureau</a>
         </span>

    </div>   
    <div class="blk">
       <span class="blk_title"> Gestion des admins </span>
         <span class="form_btnBar"> 
           <a class="pgeBtn" href="admin.php">Acc&eacute;der aux admins</a>
         </span>

    </div>      
    <div class="blk">
     
       <span class="blk_title"> Gestion des membres </span>
       
       <form method="get" action="start.php">
            <span class="form_item">
                <span class="blk_title"> Filtrer la liste </span>
            </span>
            <span class="form_item">
               <span class="label">Pr&eacute;nom :</span>
               <input type="text" class="inputText" name="prenom" value ="'.$sprenom.'"/> 
             </span>
             <span class="form_item">
               <span class="label">nom :</span>
               <input type="text" class="inputText" name="nom" value ="'.$snom.'"/> 
             </span>
             <span class="form_btnBar aft"> 
               <input class="pgeBtn" type="submit" value="Chercher">
             </span> 
       </form>
       
    
       
          <span class="blk_title"> Liste des membres <a class="pgeBtn" href="." onclick="toggleClass(document.getElementById(\'add_pop\'),\'pop_h\');return false;">Ajouter</a>&nbsp;<a class="pgeBtn" href="export.php" target="_blank"">Exporter</a></span>
          
          
       <table class="wt ">
        <tr class="tblHeader">
            <td >Nom</td>
            <td>Pr&eacute;nom</td>
            <td >Email</td>
            <td >Code</td>
            <td >Action</td>
        </tr>';
          
   
     $list = $db->getList($sprenom,$snom);

    foreach($list as $item) {
        $nom=$item["Nom"];
        $prenom=$item["Pernom"];
        $EMail=$item["Email"];
        $code=$item["Code"];
        
        echo'<tr>
                <td >'.$nom.'</td>
                <td>'.$prenom.'</td>
                <td ><a href="mailto:'.$EMail.'?subject='.getMailSubject().'&body='.getMailText($nom, $prenom, $code).'">'.$EMail.'</a></td>
                <td >'.$code.'</td>
                <td >'."<a class=\"pgeBtn\" href='pdf.php?id=$code' target=\"_blank\" >PDF</a> 
                <a class=\"pgeBtn\" href='.' 
                   onclick=\"toggleClass(document.getElementById('edit_pop'),'pop_h');
                             document.getElementById('edit_code').value='$code';
                             document.getElementById('edit_prenom').value='$prenom';
                             document.getElementById('edit_nom').value='$nom';
                             document.getElementById('edit_mail').value='$EMail';
                             return false;\">Edit</a> </td> 
            </tr>";
     
     }
     
          
          
          
    echo' 
    </table>     
    </div>
    <div class="pop_la pop_h" id="add_pop">
       <div class="pop_ct">
         <span class="blk_title"> Ajouter un membre </span>
           <form method="get" action="start.php">
          
            <span class="form_item">
               <span class="label">Pr&eacute;nom :</span>
               <input type="text" class="inputText" name="addprenom" required/> 
             </span>
             <span class="form_item">
               <span class="label">nom :</span>
               <input type="text" class="inputText" name="addnom" required/> 
             </span>
             <span class="form_item">
               <span class="label">e-mail :</span>
               <input type="text" class="inputText" name="addmail" required/> 
             </span>
             <span class="form_btnBar right"> 
               <a class="pgeBtn" href="." onclick="toggleClass(document.getElementById(\'add_pop\'),\'pop_h\');return false;">Annuler</a>
               <input class="pgeBtn" type="submit" value="Ajouter">
             </span> 
       </form>
        </div>
    </div>
    
    <div class="pop_la pop_h" id="edit_pop">
       <div class="pop_ct">
         <span class="blk_title"> Editer l\'email d\'un membre </span>
           <form method="get" action="start.php">
            <input type="hidden"   name="code" id="edit_code" readonly/>
            <span class="form_item">
               <span class="label">Pr&eacute;nom :</span>
               <input type="text" class="inputText" id="edit_prenom" readonly/> 
             </span>
             <span class="form_item">
               <span class="label">nom :</span>
               <input type="text" class="inputText" id="edit_nom" readonly/> 
             </span>
             <span class="form_item">
               <span class="label">e-mail :</span>
               <input type="text" class="inputText" id="edit_mail" name="editmail" required/> 
             </span>
             <span class="form_btnBar right"> 
               <a class="pgeBtn" href="." onclick="toggleClass(document.getElementById(\'edit_pop\'),\'pop_h\');return false;">Annuler</a>
               <input class="pgeBtn" type="submit" value="Enregistrer">
             </span> 
       </form>
        </div>
    </div>

</body>
</html>';

?>


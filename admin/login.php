<?php
include '_commonBlock.php';
writeHead();

echo'
<body>';
    
writeHeader();

echo' 
    <div class="blk">
       <span class="blk_title"> CONNECTION </span>
       
       <form action="./identification.php" method="post">
         <span class="form_item">
           <span class="label">Nom d\'utilisateur:</span>
           <input class="inputText"  type="text" name="login" value="" /><br/>
         </span>
         <span class="form_item">
           <span class="label">Mot de passe:</span>
           <input class="inputText"  type="password" name="mdp" value="" /><br/>
         </span>
         <span class="form_btnBar"> 
           <input class="pgeBtn" type="submit" value="Se connecter">
         </span>
        </form>
    </div>   

</body>
</html>';

?>


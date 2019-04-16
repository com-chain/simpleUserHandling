Pour faire fonctionner:

(optionel) Un server mysql.
Un server php.


CHOIX DE LA DB
--------------


pour basculer sur MYSQL:
  assurez-vous que "db.php" ait la ligne suivante (fin du fichier)
  $db = new MySqlDB();
pour basculer sur SQLite:
  assurez-vous que "db.php" ait la ligne suivante
  $db = new MyLiteDB();
  
  assurez vous que dans "db.php" le constructeur de MyLiteDB pointe vers votre fichier de DB
  $this->open('membres.db');
  
  
PERSONALISATION
---------------
L'utilisation des couleurs et des logos de votre monnaie se fait par des changement ans le dossier
"resources"

1) le fichier "resources/const.php" doit contenir le nom de votre monnaie (définit par ComChain) ainsi que les texte pour la génération d'e-mail.
2) Logo et css doivent être adaptés
3) le document produit se trouve dans le fichier "pdf.php"


INSTALLATION
------------
1) Exécuter le contenu du fichier DataBase.sql dans le server mysql.

2) Configurer le server php pour présenter le contenu du dossier admin

3) Installer la clef privée.


Il faut la clef privée au format .pem accessible 
(une clef générée avec key gen peut être convertie en utilisant:
openssl rsa -in ~/.ssh/id_rsa -outform pem > id_rsa.pem)

le chemin d'accès à la clef doit être spécifié dans str.php ligne 12

Vous pouvez tester que la clef privée est trouvée en appelant 

test_str.php?id=123456789

et en vérifaint qu'aucune exception n'est levée.

4) Une fois la clef privée en place supprimer le fichier "test_str.php"


Remarques:

- Le texte du document est dans "pdf.php" il manque les urls pour le server de la monnaie

- pensez a faire des back-up régulier de la base de données 


STRUCTURE DU SITE
-----------------

Ces pages d'admin présentent:
- la liste des membres (avec possibilité d'ajouter un membre et de générer le pdf)
- un lien sur le site d'admin de la monnaie (il faut ensuite le compte 0x... correspondant)
- une page de gestion des admins utilisateurs de ces pages


UTILISATION
-----------

Les instructions SQL créent un utilisateurs actif du nom de Admin_0, 
son mot de passe est identique à son nom.

première utilisation:
1) ouvrez dans un navigateur la page "login.php"
2) se loger en temps qu'Admin_0
3) Cliquez sur le bouton "Accéder aux utilisateurs"
4) modifier le mot de passe.

Ajouter un membre et générer un code d'accès:
1) se loger
2) cliquer sur => Liste des membres => "Ajouter"
3) Entrer le nom , prénom et mail du nouveaux membre
4) Valider l'acion. Le membre apparait dans la liste.
5) Cliquez sur le bouton "PDF" sur la ligne correspondante de la grille des membres.

Rechercher un membre:
1) se loger
2) dans "Filtrer la liste" entrer le début d'un nomet/ou prénom
3) cliquer sur "Chercher"
4) La liste est restrainte au(x) membre(s) correspondant(s)

Ajouter un utilisateur pour les pages:
1) se loger
2) Cliquer sur le bouton "Accéder aux utilisateurs"
3) Cliquer nouvel utilisateur
4) Entrer l'identifiant le mot de passe et selectionner "Utilisateur Actif"
5) Cliquer sur "Créer"
6) Transmettre à l'utilisateur ses identifiant et mot de passe et lui demander de modifier son mot de passe à sa première connection.
Remarque: un utilisateur non actif ne peut accédr aux pages.


Noubliez pas de vous déconnecter!




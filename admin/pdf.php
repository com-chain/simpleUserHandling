<?php
require('fpdf/fpdf.php');
include 'str.php';
include 'db.php';


$res = $db->validMember($_GET['id']);
if ($res['Valid']!=True){
    echo "Hello!";
    exit;
}




class PDF extends FPDF
{
function Font(){
   // $this->AddFont('HelveticaLt','','/HelveticaLt.php');
}

// En-tête
function Header()
{
    // Logo
    $this->Image('resources/wide-logo.png',10,6,50);
    // Police Arial gras 15
    $this->SetFont('Arial','B',14);
    // Décalage à droite
   // $this->Cell(73);
    // Titre
    $this->SetXY (15,25);
    $this->Cell(0,10,utf8_decode('Léman électronique : Code d\'autorisation personnel'),0,0,'C');
    // Saut de ligne
    $this->Ln(10);
    $this->AjoutBoldParagraphe('Attention ! Ce document est à conserver précieusement dans vos dossiers !');
}

// Pied de page
function Footer()
{
    $this->SetTextColor(0,111,180);
    // Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    $this->SetFont('Helvetica','',8);
    // Numéro de page
    // bleu
    $this->Cell(0,10,utf8_decode('Monnaie Léman | http://www.monnaie-leman.org | info@monnaie-leman.org'),0,0,'C');
}


function AjoutText_2($text){
    // Helvetica 10
    $this->SetFont('Helvetica','',9);
    $this->MultiCell(180,5,utf8_decode($text));  
}

function AjoutText($text){
    // Helvetica 10
    $this->SetFont('Helvetica','',9);
    $this->Write(5,utf8_decode($text));  
}

function AjoutBold($text){
    // Helvetica 10
    $this->SetFont('Helvetica','B',9);
    $this->SetTextColor(240,113,18);
    $this->Write(5,utf8_decode($text));
    $this->SetTextColor(0,0,0);
}

function AjoutBold_2($text){
    // Helvetica 10
    $this->SetFont('Helvetica','B',9);
    $this->SetTextColor(240,113,18);
    $this->MultiCell(180,5,utf8_decode($text),0,'C');
    $this->SetTextColor(0,0,0);
}

function AjoutLien($text,$liens){
    $this->SetTextColor(0,0,255);
    $this->Write(5,utf8_decode($text),$liens);
    $this->SetTextColor(0,0,0);
}


function SautDeLigne(){
    $this->Ln();
}

function LigneVide(){
    $this->Ln();
    $this->Ln();
}

function AjoutParagraphe($text){
    $this->AjoutText_2($text);
    $this->SautDeLigne();
}


function AjoutBoldParagraphe($text)
{
    $this->AjoutBold_2($text);
    $this->SautDeLigne();
}

function AjoutCadreParagraphe($text)
{
    // Helvetica 10
    $this->SetFont('Courier','',9);
    // Sortie du texte justifié
    $this->MultiCell(180,5,utf8_decode($text),1,'C');
    $this->Ln();
}
}

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->Font();
$pdf->SetMargins(15,0);
$pdf->AliasNbPages();
$pdf->AddPage();



$pdf->AjoutText("Bonjour ".$res['Name'].",");
$pdf->LigneVide();
$pdf->AjoutText("Ce document contient votre Code d'");

$pdf->SetFont('Helvetica','I',9);
$pdf->Write(5,utf8_decode("autorisation"));
$pdf->SetFont('Helvetica','I',9);

$pdf->AjoutText(" personnel. Il consiste en une suite de chiffres et de lettres :");

$pdf->LigneVide();
$pdf->AjoutCadreParagraphe(getStr($res['code']));

$pdf->AjoutText("Ce code d'autorisation vous ");

$pdf->SetFont('Helvetica','I',9);
$pdf->Write(5,utf8_decode("autorise"));
$pdf->SetFont('Helvetica','I',9);

$pdf->AjoutText(" à créer au sein de l'application Biletujo autant de comptes personnels que vous le désirez (un compte perso, un compte famille, le compte « entreprise » ou « association » que vous gérez, etc.). La marche à suivre pour créer votre portefeuille et le synchroniser sur vos différents appareils est décrite en détail dans la ");

$pdf->SetFont('Helvetica','I',9);
$pdf->Write(5,utf8_decode("Marche à suivre : création d'un portefeuille sur l'application Biletujo"));
$pdf->SetFont('Helvetica','I',9);

$pdf->AjoutText(", que nous vous conseillons vivement de lire. En tous les cas, par prudence, il faut : ");

$pdf->SetMargins(20,0);
$pdf->LigneVide();
$pdf->AjoutText("1. Commencer la procédure d'autorisation sur un ordinateur à la page ");
$pdf->AjoutLien('https://wallet.cchosting.org/','https://wallet.cchosting.org/');
$pdf->LigneVide();
$pdf->AjoutText('2. Suivre les instructions pour la création de votre/vos comptes.
Votre code d’autorisation personnel ci-dessus {"Id":...} vous sera demandé par l\'application durant l\'ouverture de chaque compte.');
$pdf->LigneVide();
$pdf->AjoutText('3. Une fois votre compté créé, réaliser une ');
$pdf->AjoutBold('sauvegarde numérique');
$pdf->AjoutText(' et une ');
$pdf->AjoutBold('sauvegarde papier');
$pdf->AjoutText('.');
$pdf->LigneVide();
$pdf->AjoutText('4. Conserver les précieusement ainsi que le ');
$pdf->AjoutBold('mot de passe');
$pdf->AjoutText(' que vous aurez choisi au moment de la création de chacun de vos comptes.');
$pdf->SautDeLigne();
$pdf->AjoutBold('Si vous veniez à perdre vos sauvegardes ou le mot de passe il ne serait plus possible de récupérer les lémans chargés sur le compte correspondant.');
$pdf->LigneVide();
$pdf->AjoutText('5. Veuillez prendre note que votre compte devra encore être activé avant de pouvoir recevoir et envoyer des lémans.');

$pdf->SetMargins(15,0);
$pdf->LigneVide();



$pdf->AjoutParagraphe('La sauvegarde papier de chaque compte permet d\'y accéder depuis l\'application Biletujo sur votre téléphone. Vous pouvez télécharger l\'application Biletujo en vous servant des QR ci-dessous:');

$pdf->LigneVide();
$pdf->LigneVide();
$pdf->LigneVide();
$pdf->LigneVide();

$pdf->Image('resources/Biletujo_Android.png',35,213,40);
$pdf->Image('resources/Biletujo_Apple.png',110,213,40);
$pdf->AjoutText("Le guide d'utilisation complet d'application Biletujo est accessible en cliquant sur l'icône        (aide/help).");

$pdf->Image('resources/help.png',138,254,7);
$pdf->LigneVide();
$pdf->AjoutText("Nous vous souhaitons d'heureuses transactions lémaniques !");
$pdf->SautDeLigne();
$pdf->AjoutText("                                                                                     Monnaie Léman, Equipe administration / IT");
$pdf->Output();
?>

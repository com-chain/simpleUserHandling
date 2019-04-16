<?php
require('fpdf/fpdf.php');
include 'str.php';

class PDF extends FPDF
{
// En-tête
function Header()
{
    // Logo
    $this->Image('resources/logo.png',10,6,20);
    // Police Arial gras 15
    $this->SetFont('Arial','B',15);
    // Décalage à droite
    $this->Cell(73);
    // Titre
    $this->SetXY (10,10);
    $this->Cell(0,10,utf8_decode('Bienvenu sur <Nom Monnaie>'),0,0,'C');
    // Saut de ligne
    $this->Ln(20);
}

// Pied de page
function Footer()
{
    // Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    // Police Arial italique 8
    $this->SetFont('Arial','I',8);
    // Numéro de page
    $this->Cell(0,10,utf8_decode('Monnaie Lémã - http://www.monnaie-leman.org'),0,0,'C');
}

function AjoutParagraphe($text)
{
    // Times 12
    $this->SetFont('Times','',12);
    // Sortie du texte justifié
    $this->MultiCell(0,5,utf8_decode($text));
    $this->Ln();
}
function AjoutBoldParagraphe($text)
{
    // Times 12
    $this->SetFont('Courier','',10);
    // Sortie du texte justifié
    $this->MultiCell(0,5,utf8_decode($text),0,'C');
    $this->Ln();
}
}

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->AjoutParagraphe('');
$pdf->AjoutParagraphe("Bonjour ".$_GET['nom'].",");
$pdf->AjoutParagraphe("Ce document contient votre code personnel permetant la création de compte <Nom Monnaie>.");


$pdf->AjoutParagraphe("Voici la marche à suivre pour bien démarrer:");

$link = $pdf->AddLink();
$pdf->Write(5,'1. Sur un ordinateur, visitez la page ');
$pdf->SetTextColor(0,0,255);
$pdf->Write(5,'https://wallet.monnaie-leman.org/','https://wallet.cchosting.org/');
$pdf->SetTextColor(0,0,0);

$pdf->AjoutParagraphe('');
$pdf->AjoutParagraphe('2. Suivez les instructions pour l\'ouverture de votre compte.');
$pdf->AjoutParagraphe('Le code suivant vous sera demandée par l\'application durant l\'ouverture de votre compte.');

$pdf->AjoutBoldParagraphe(getStr($_GET['id']));

$pdf->Write(5,utf8_decode('Une fois votre compte crée, faite '));
$pdf->SetFont('Times','B',12);
$pdf->Write(5,utf8_decode('une sauvegarde '));
$pdf->SetFont('Times','',12);
$pdf->Write(5,utf8_decode('et '));
$pdf->SetFont('Times','B',12);
$pdf->Write(5,utf8_decode('une sauvegarde papier '));
$pdf->SetFont('Times','',12);
$pdf->Write(5,utf8_decode('. Conservez les précieusement ainsi que '));
$pdf->SetFont('Times','B',12);
$pdf->Write(5,utf8_decode('le mot de passe '));
$pdf->SetFont('Times','',12);
$pdf->Write(5,utf8_decode('que vous aurez choisit au moment de la création de votre compte.'));
$pdf->AjoutParagraphe('');

$pdf->SetTextColor(255,0,0);
$pdf->SetFont('Times','B',12);
$pdf->AjoutBoldParagraphe('Si vous veniez à perdre vos sauvegardes et/ou le mot de passe il ne serait plus possible de récupérer les <Nom Monnaie> chargées sur le compte correspondant.');
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Times','',12);

$pdf->AjoutParagraphe('La sauvegarde papier permet d\'ouvrir votre compte depuis l\'application Biletujo sur votre téléphone. Vous pouvez télécharger l\'application Biletujo en vous servant des QR ci-dessous:');


$pdf->AjoutParagraphe('');
$pdf->AjoutParagraphe('');
$pdf->AjoutParagraphe('');
$pdf->AjoutParagraphe('');
$pdf->AjoutParagraphe('');
$pdf->AjoutParagraphe('');
 $pdf->Image('resources/Biletujo_Android.png',35,173,60);
 $pdf->Image('resources/Biletujo_Apple.png',110,173,60);


$pdf->AjoutParagraphe('Veuillez prendre note que votre compte devra encore être activé avant de pouvoir recevoir et envoyer des <Nom Monnaie>');


$pdf->AjoutParagraphe("Cordialement,");
$pdf->AjoutParagraphe("<Nom Monnaie>");
$pdf->Output();
?>

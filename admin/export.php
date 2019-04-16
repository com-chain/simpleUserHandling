<?php
include 'checkUser.php';
include 'db.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="sample.csv"');
$data = array(
        'Nom,Prénom,Email,Code'
);

$list = $db->getList($sprenom,$snom);

foreach($list as $item) {
    $nom=$item["Nom"];
    $prenom=$item["Pernom"];
    $EMail=$item["Email"];
    $code=$item["Code"];
    array_push($data, $nom.','.$prenom.','.$EMail.','.$code);
}



$fp = fopen('php://output', 'wb');
foreach ( $data as $line ) {
    $val = explode(",", $line);
    fputcsv($fp, $val);
}
fclose($fp);


          

              
?>


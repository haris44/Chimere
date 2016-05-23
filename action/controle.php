<?php

session_start();

include_once '../class/etape.class.php';
include_once '../class/bijou.class.php';

$emp = $_SESSION['idemp'];
$terminer = $_POST['terminer'];
$idbijou = $_POST['idbijou'];
$numeroetape = $_POST['numeroetape'];
$photo = "img/controle.jpg";

$date = date("Y-m-d");
$heure = date("H:i:s");
$datetime = "$date $heure";
	
if($terminer == 1){
	if($_POST['submit'] == "Déclarer non conforme"){
		
		$metier = $_POST['nextmetier'];
		$commentaire =  $_POST['com'];
	}

	else{
		
		$metier = 2;
		Bijou::SetEtat($idbijou, 1);
	}
}
if($terminer == 0){
	if($_POST['submit'] == "Déclarer non conforme"){
		
		$metier  = $_POST['nextmetier'];
		$commentaire =  $_POST['com'];
		
	
	}

	else{
		$metier = $_POST['metier'];
	}
}

$numeroetape++;
echo $numeroetape;
echo "<br>";
echo $idbijou;
echo "<br>";
echo $metier;
echo "<br>";
echo $datetime;
echo "<br>";
echo $emp;

Etape::AjouterEtapeControleur($idbijou, 0, 0, 0, $metier, $emp, $photo, $numeroetape, $datetime, $commentaire, $emp);

header('Location: ../indexartisan.php');


?>
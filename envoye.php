<?php
	
	session_start();
	include_once 'class/etape.class.php';
	
	$poidsmetal = $_POST['poidmetal'];
	$poidpierre = $_POST['poidpierre'];
	$tempspasse = $_POST['tempspasse'];
	$nextmetier = $_POST['nextmetier'];	
	$etapeencours = $_POST['etapeencours'];	
	$commentaires = $_POST['com'];	

	$bijou = unserialize(rawurldecode($etapeencours));	

	
		
	
	$employeeencours = $_SESSION['idemp'];
	
	$idbijou = $bijou->idbijou;
	$numeroetape = $bijou->numeroetape + 1;
	echo 1;
	$photo = "fichier/$idbijou/$numeroetape.jpg";
	echo $photo;
	
	$resultat = move_uploaded_file($_FILES['icone']['tmp_name'],$photo);
	echo "<img src='$photo'>";
	$date = date("Y-m-d");
	$heure = date("H:i:s");
	$datetime = "$date $heure";

	if($_POST['submit'] == "Terminer le bijou"){
		$nextmetier = 4;	
	}
	
	echo $nextmetier;
	
	$bijou->Ajoutercommentaire($commentaires, $photo);
	$bijou->termineretape();
	
	Etape::AjouterEtape($idbijou, $poidsmetal, $poidpierre, $tempspasse, $nextmetier, $employeeencours,  $numeroetape, $datetime);
	
	header('Location: indexartisan.php');

	
		?>
	
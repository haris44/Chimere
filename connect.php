<?php

include_once 'class/employee.class.php';	

if (isset($_GET['emp'])) {
	
		session_start ();
		$_SESSION['idemp'] = $_GET['emp'];
		
		$employee = Employee::BDDtoEmploye($_GET['emp']);
		
		$_SESSION['nom'] = $employee[0]->nom;
		$_SESSION['prenom'] = $employee[0]->prenom;
		$_SESSION['idmetier'] = $employee[0]->idmetier;
		$_SESSION['nommetier'] = $employee[0]->nommetier;
	
	header('Location: indexartisan.php');

}
else {
	header('Location: index.php');
}
?>	

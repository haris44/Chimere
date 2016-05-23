<?php
	$idemployee = $_GET['id'];
	include_once '../class/employee.class.php';
	Employee::EnVacances($idemployee);
	header('Location: ../indexartisan.php');
	
	?>
	
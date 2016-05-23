<?php
	$idemployee = $_GET['id'];
	include_once '../class/employee.class.php';
	Employee::RevenuVacances($idemployee);
	header('Location: ../indexartisan.php');
	
	?>
	
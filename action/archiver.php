<?php
	
	$idbijou = $_GET['idbijou'];
	
	include_once '../class/bijou.class.php';
	
	Bijou::Archiver($idbijou);
	
			header('Location: ../indexartisan.php');
	?> 
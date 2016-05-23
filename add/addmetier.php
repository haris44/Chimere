<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
  		<link rel="stylesheet" href="style.css">
		<title></title>
	</head>
	<body>
		
		
		<form action="addmetier.php" method="post">
			<label>Nom du métier</label><input type="text" name="nom" /></br>
			<input type="submit">
		</form>
		
		<?php 
			include_once '../class/metier.class.php';

			if (isset($_POST["nom"])){	
						

				$nommetier = $_POST['nom'];
				Metier::AjouterMetier($nommetier);
			
			}
	
			?>
			
		
	</body>
</html>

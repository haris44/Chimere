<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
  		<link rel="stylesheet" href="../css/indexartisan.css">
  		<link rel="stylesheet" href="../css/menu.css">
		<title></title>
	</head>
	<body>
            <div id="menu">
                <img src="../img/logo.png" alt="" width="100%"/>		
            </div>
            
          		
<?php
session_start ();
if (isset($_SESSION['idemp'])) {

	
?>


		<div id="menu">
			<a href="../indexartisan.php"><img src="../img/logo.png" alt="" width="100%"/></a>
			<br/>			
						
			
		</div>
            <div id="bidonjour"><b>Bonjour,</b> <?php  echo $_SESSION['prenom']; echo " "; echo $_SESSION['nom'];?></div>
		<a href="../deco.php"><div id="deco">Déconnexion			
			</div></a>
			
		<?php
		if($_SESSION['nommetier'] == "Bijoutier"){
	
		echo "
		 <div id='gestion'>
	            
                <ul id='menus'>
					<li>
							<a href='#'>  Administrer le site </a>
												<ul>
                        	<li><a href='addemployee.php'>Employées</a></li>
                        	<li><a href='addclient.php'>Client</a></li>
                        	<li><a href='addbijou.php'>Bijoux</a></li>
							<li><a href='../vente.php'>Boutique</a></li>
							<li><a href='../archive.php'>Archives</a></li>
							<li><a href='../action/afficheremp.php'>Vacances</a></li>
                		</ul>

					</li>   
				</ul>
				
            </div>";
            }
            
			?>

		
		
		<div id="affichagebijou">
		
		<img src="../img/pierre.png" alt="" width="25px" style="margin-top: 10px;"/>
                <h1> Ajouter un employées</h1>	
                <hr style="margin-top: 5px;"> 




		
		<?php 
			include_once '../class/employee.class.php';
			include_once '../class/metier.class.php';
			$Metiers = Metier::BDDtoMetier();
			
		?>
		
		<br>
		<form action="addemployee.php" method="post">
			<label>Nom de l'employée : </label><input type="text" name="nom" required ><br>
			<label>Prénom de l'employée : </label><input type="text" name="prenom" required ><br>
			<label>Fonction : </label><select name="metiers" size="1">
			<?php
				foreach($Metiers as $values ){
					echo "<option value='$values->idmetier'> $values->nommetier";
				}	
			?>	
			</select><br>
						<input type="submit">
						</form>
		
			
			
			<?php 
			

			if (isset($_POST["nom"])){	
				

				$nom = $_POST['nom'];
				$prenom = $_POST['prenom'];
				$metiers = $_POST['metiers'];

				
				Employee::AjouterEmployee($nom, $prenom, $metiers);
			
							}
	
	}else {
				header('Location: ../indexartisan.php');
			}
			?>
	
			
			
		</div>
	</body>
</html>
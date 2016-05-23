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
                <h1 >Ajouter un bijou</h1>		
                <hr style="margin-top: 5px;"> 



		<?php 
			include_once '../class/bijou.class.php';
			include_once '../class/client.class.php';
			$Clients = Client::BDDtoClient();
			include_once '../class/metier.class.php';
			$Metiers = Metier::BDDtoMetier();
			
			
		?>
		
		<br>
		<form action="addbijou.php" method="post" enctype="multipart/form-data">
			<label>Client</label><select name="client"required >
				
			<?php
				foreach($Clients as $value ){
					echo "<option value='$value->id'> $value->nom $value->prenom";
				}	
			?>	
			</select><br>
			<label>Devis : </label><input type="number" name="devis" required ><br>
			<label>Estimation : </label><input type="number" name="estimation" required ><br>
			<label>Nombre d'heure prévu : </label><input type="number" name="hprevu" required ><br>
			<label>Description : </label><input type="text" name="description" required ><br>
			<label>Motif de réparation : </label><input type="text" name="motif" required ><br>
			
			<label>Envoyé le travail aux : </label><select name="nextempl" size="1">
			<?php
				foreach($Metiers as $values ){
					if($values->nommetier == $_SESSION['nommetier'] || $values->nommetier == "Bijoutier" | $values->nommetier == "Contrôleur"){
						
					}
					else
					echo "<option value='$values->idmetier'> $values->nommetier";
				}	
			?>	

			</select><br>
			<label>Photo du bijou (.jpg uniquement) : </label><input type="file" name="icone" id="icone" required ><br/>
			<br>
			<input type="submit">
		</form>
		
			
			
			<?php 
			

			if (isset($_POST["client"])){	
				
				// Je commence par m'occuper du stockage de la photo sur le serveur
				
				$lastid = Bijou::SelectMaxId();
				$newid = $lastid + 1;
				echo $newid;
				
				mkdir("../fichier/$newid", 0777, true);					
				$photo = "../fichier/$newid/0.jpg";
				$resultat = move_uploaded_file($_FILES['icone']['tmp_name'],$photo);
				$photo = "fichier/$newid/0.jpg";
				
				// Je récupère ce qui est nécessaire à l'entrée du projet en BDD
				$date = date("Y-m-d");
				$heure = date("H:i:s");
				$datetime = "$date $heure";
				echo $datetime;
				$etat = 0;
				$idclient = $_POST['client'];
				$estimation = $_POST['estimation'];
				$devis = $_POST['devis'];
				$hprevu = $_POST['hprevu'];
				$description = $_POST['description'];
				$motif = $_POST['motif'];
				$metierssuivant = $_POST['nextempl'];
				
				Bijou::AjouterBijou($idclient, $devis, $estimation, $hprevu, $datetime, $photo, $description, $motif, $etat, $metierssuivant, $newid);
				
					header('Location: ../indexartisan.php');
			
							}
	
			}else {
				header('Location: ../indexartisan.php');
			}
			?>

			
			
		</div>
	</body>
</html>
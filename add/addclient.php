<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
  		<link rel="stylesheet" href="style.css">
		<title>Ajouter un client</title>
	</head>
	<body>
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
               		<h1>Ajouter un client </h1>	
                <hr style="margin-top: 5px;"> 

		<br>
		<form action="addclient.php" method="GET">		
			<label>Nom : </label><input type="text" name="nom" required/></br>
			<label>Prénom : </label><input type="text" name="prenom" required/></br>
			<label>Téléphone (0102030405) : </label><input type="text" name="telephone" required/></br>
			<label>Email : </label><input type="email" name="courriel" required/></br>
			<input type="submit">
		</form>
		<?php 
			

			if (isset($_GET["nom"])){	
						
				include_once '../class/client.class.php';		
				
				$nom = $_GET["nom"];
				$prenom = $_GET["prenom"];
				$telephone = $_GET["telephone"];
				$mail = $_GET["courriel"];
		
					
				Client::AjouterUnClient($nom, $prenom, $telephone, $mail);			
				
				echo "Le Client $nom $prenom à bien été ajouté en BDD";
				
			}
	
	}else {
				header('Location: ../indexartisan.php');
			}
			?>
	
			
			
		</div>
	</body>
</html>
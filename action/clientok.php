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
                        <li><a href='../add/addemployee.php'>Employées</a></li>
                        	<li><a href='../add/addclient.php'>Client</a></li>
                        	<li><a href='../add/addbijou.php'>Bijoux</a></li>
							<li><a href='../vente.php'>Boutique</a></li>
							<li><a href='../archive.php'>Archives</a></li>
							<li><a href='afficheremp.php'>Vacances</a></li>

                		</ul>
					</li>   
				</ul>
				
            </div>";
            }
            
			?>

		
		
		<div id="affichagebijou">
		
		<img src="../img/pierre.png" alt="" width="25px" style="margin-top: 10px;"/>
                <h1> Récupération du bijou par le Client </h1>		
                <hr style="margin-top: 5px;"> 



<?php 
	
	include_once '../class/bijou.class.php';
	
	if(isset($_POST['prix']) && isset($_POST['idbijou'])){
	
		Bijou::MettrePrixFinal($_POST['idbijou'], $_POST['prix']);
		Bijou::Archiver($_POST['idbijou']);
		
	header('Location: ../indexartisan.php');
	
	}
	
	else{
		
		$idbijou = $_GET['idbijou'];
		
	echo"
	<br>
	<form action='clientok.php' method='post'>
	<label><b>Prix de l'objet : </b></label><input type='number' name='prix' required /></br>
	<input type='hidden' name='idbijou' value='$idbijou' /></br>
	<input type='submit'>
	</form>";

	}
	
		}else {
				header('Location: ../indexartisan.php');
			}
			?>
	
			
			
		</div>
	</body>
</html>
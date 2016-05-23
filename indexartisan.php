<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
  		<link rel="stylesheet" href="css/indexartisan.css">
  		<link rel="stylesheet" href="css/menu.css">
		<title></title>
	</head>
	<body>
		
		
		
<?php
include_once 'class/bijou.class.php';
session_start ();
if (isset($_SESSION['idemp'])) {

	
?>


		<div id="menu">
			<a href="indexartisan.php"><img src="img/logo.png" alt="" width="100%"/></a>
			<br/>			
						
			
		</div>
            <div id="bidonjour"><b>Bonjour,</b> <?php  echo $_SESSION['prenom']; echo " "; echo $_SESSION['nom'];?></div>
		<a href="deco.php"><div id="deco">Déconnexion			
			</div></a>
			
		<?php
		if($_SESSION['nommetier'] == "Bijoutier"){
	
		echo "
		 <div id='gestion'>
	            
                <ul id='menus'>
					<li>
							<a href='#'>  Administrer le site </a>
						<ul>
                        	<li><a href='add/addemployee.php'>Employées</a></li>
                        	<li><a href='add/addclient.php'>Client</a></li>
                        	<li><a href='add/addbijou.php'>Bijoux</a></li>
							<li><a href='vente.php'>Boutique</a></li>
							<li><a href='archive.php'>Archives</a></li>
							<li><a href='action/afficheremp.php'>Vacances</a></li>

                		</ul>
					</li>   
				</ul>
				
            </div>";
            }
            
			?>
			
		<div id="affichagebijou">
		<img src="img/pierre.png" alt="" width="25px" style="margin-top: 10px;"/>
			<h1 >Travaux à traiter</h1>		
			<hr style="margin-top: 5px;"> 


			<?php
		if($_SESSION['nommetier'] == "Bijoutier"){
	
		echo "
		 	<a href='add/addbijou.php'>
			<div id='carre' class='white'><b>Ajouter un bijou</b>
            	<center>
            		<img src='img/add3.png' alt='' class='bijou' title='Pendentif de Mme Bordat'>
            	</center>          	
				   <p class='envoye'> Cliquez ici pour ajouter un bijou </p>      
			</div>
			</a>";
            }
			
				if($_SESSION['nommetier'] != "Bijoutier" && $_SESSION['nommetier'] != "Contrôleur"){
					Bijou::AfficherBijouIndex($_SESSION['idmetier']);
				}
				else if($_SESSION['nommetier'] == "Bijoutier"){
					Bijou::AfficherBijouIndex($_SESSION['idmetier']);

					echo	
					"<br><img src='img/pierre.png' alt='' width='25px' style='margin-top: 10px;'/>
					<h1 >Tous les travaux de la bijouterie</h1>		
					<hr style='margin-top: 5px;'> ";
					
					Bijou::AfficherBijouTotal();
				}
				else if($_SESSION['nommetier'] == "Contrôleur"){
					Bijou::AfficherBijouIndex(4);

					echo	
					"<br><img src='img/pierre.png' alt='' width='25px' style='margin-top: 10px;'/>
					<h1 >Tous les travaux de la bijouterie</h1>		
					<hr style='margin-top: 5px;'> ";
					
					Bijou::AfficherBijouTotal();
				}
				
			?>
		
		</div>
		
		
		<?php
			}else {
				header('Location: index.php');
			}
			?>
	</body>
</html>

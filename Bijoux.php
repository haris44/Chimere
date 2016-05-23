<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
  		<link rel="stylesheet" href="css/bijoux.css">
		<title></title>
	</head>
	<body>
		
			 <?php
			 	session_start ();
			 	if (isset($_SESSION['idemp'])) {
				 	
				 	
			 	if (!isset($_GET['id'])){
				 	header('Location: indexartisan.php');			 	
			 	}
			 	
			 	include_once 'class/bijou.class.php';
			 	$idbijou = $_GET['id'];
			 	include_once 'class/metier.class.php';
			 	$Metiers = Metier::BDDtoMetier();			
			 	$bijou = Bijou::SelectBijou($idbijou);
			 
			 	$sender = rawurlencode(serialize($bijou));
			 ?>
		<div id="menu">
			<a href="indexartisan.php"><img src="img/logo.png" alt="" width="100%"/></a>
			<br/>			

		</div>
		
		<a href="deco.php"><div id="deco">Déconnexion			
			</div></a>
		<div id="titre">
		<img src="img/pierre.png" alt="" width="25px" style="margin-top: 10px;"/>
		<h1 >Le bijou</h1>	
		<hr/ style="margin-top: 5px;">
		
		
		 <?php
			 // Gestion de l'affichage en fonction du métier, en premier si c'est un artisan (aurait pu être géré en objet) 
			  if($_SESSION['nommetier'] != "Bijoutier" && $_SESSION['nommetier'] != "Contrôleur"){
			 ?>
		
	
		<form action="envoye.php" method="post" enctype="multipart/form-data">
		
		<p> <b>Description du bijou : </b> <?php echo $bijou->description;?> <br><br>
			<b> Type de réparation :</b>  <?php echo $bijou->typereparation;?> <br><br>
			<b>Poids de metal utilisé : </b> <input type="number" name="poidmetal" required > gr<br>
			<b>Poids de pierre utilisé : </b> <input type="number" name="poidpierre" required > gr<br>
			<b>Temps passé sur le bijou : </b> <input type="number" name="tempspasse" required ><br>
			<input type="hidden" name="etapeencours" value=<?php echo $sender; ?>>
			<b> Metier suivant (sauf si bijou terminé) :</b> <select name="nextmetier">

				<?php
			// J'affiche dans la liste la liste des artisans à qui l'artisan en cours pour envoyer le projet 
				foreach($Metiers as $values ){
					if($values->nommetier == $_SESSION['nommetier'] || $values->nommetier == "Bijoutier" | $values->nommetier == "Contrôleur"){
						
					}
					else
					echo "<option value='$values->idmetier'> $values->nommetier";
				}	
			?>	
			</select> <br>
			<label><b>Photo du bijou (.jpg uniquement) : </b></label><input type="file" name="icone" id="icone" required ><br/>
				 
		
		<div id="commentaire"><br><br><br>
			<b>Votre commentaire :</b><br>
			<textarea rows="10" cols="90" name="com" required ></textarea>
			<br>
			
		</div>
		
		</div>
				
		
			<input type="submit" name="submit" class="prendreencharge" value="Envoyer le bijou"></div>	
			<input type="submit" name="submit" class="terminer" value="Terminer le bijou"></div>	
			</form>
			</div>
		<?php }
			// Ici si c'est le bijoutier
			else if($_SESSION['nommetier'] == "Bijoutier"){
				
				Bijou::AfficherInformation($idbijou);
				
			}
			// Enfin si c'est le controlleur 
			else if($_SESSION['nommetier'] == "Contrôleur"){
				
				Bijou::AfficherInterfaceControleur($idbijou);
				
			}
			?> 
				
			<div id="carre" class="red"><?php echo $bijou->description;?> 
            	<center>
            		<img src="<?php echo $bijou->photo; ?>" alt="" class="bijou" title="Pendentif de Mme Bordat">
            	</center>          	
				<p class="envoye">Envoyé par : <?php echo $bijou->employeeencours;?> </p>      
		</div>
		
		<div id="commentaires">
			<hr>
			<?php 
				$bijou->AfficherCommentaires();				
			?>
			
		</div>
	

		

<?php }else {
	header('Location: index.php');
}?>
	</body>
</html>

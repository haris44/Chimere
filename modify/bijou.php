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
                <h1 >Modifier un bijou</h1>		
                <hr style="margin-top: 5px;"> 



		<?php 
		
		
		include_once '../class/bijou.class.php';
			include_once '../class/client.class.php';
			$Clients = Client::BDDtoClient();
			include_once '../class/metier.class.php';
			$Metiers = Metier::BDDtoMetier();


		if (isset($_GET['idbijou'])){
			
						
			
			$bijou = Bijou::SelectBijouModify($_GET['idbijou']);
			$idbjoux = $_GET['idbijou'];
		?>
		
		<br>
		<form action="bijou.php" method="post" enctype="multipart/form-data">
			<label>Client</label><select name="client"required >
				
			<?php
				echo "<option value='$bijou[0]'> $bijou[1] $bijou[2]";
				
				foreach($Clients as $value ){
					echo "<option value='$value->id'> $value->nom $value->prenom";
				}	
			
			echo"
			</select><br>
			<label>Devis : </label><input type='number' name='devis' value='$bijou[3]' required ><br>
			<label>Estimation : </label><input type='number' name='estimation' value='$bijou[4]' required ><br>
			<label>Nombre d'heure prévu : </label><input type='number' name='hprevu' value='$bijou[5]' required ><br>
			<label>Description : </label><input type='text' name='description' value='$bijou[6]' required ><br>
			<label>Motif de réparation : </label><input type='text' name='motif'  value='$bijou[7]' required ><br>
			<input type='hidden' name='idbijou'  value='$idbjoux' required ><br>
			<br>
			<input type='submit'>
			</form>";
		
		
			
			
			
			}
			else if (isset($_POST["client"])){	
				

				$idclient = $_POST['client'];
				$estimation = $_POST['estimation'];
				$devis = $_POST['devis'];
				$hprevu = $_POST['hprevu'];
				$description = $_POST['description'];
				$motif = $_POST['motif'];				
				$idbijoux = $_POST['idbijou'];	
				
				echo $idclient;
				
				Bijou::ModiferBijou($idbijoux, $idclient, $devis, $estimation, $hprevu, $description, $motif);
				
					header('Location: ../indexartisan.php');
			
							}
	
			}else {
				header('Location: ../indexartisan.php');
			}
			?>

			
			
		</div>
	</body>
</html>
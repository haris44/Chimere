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
							<li><a href=#>Vacances</a></li>
                		</ul>

					</li>   
				</ul>
				
            </div>";
            }
            
			?>

		
		
		<div id="affichagebijou">
		
		
		<img src="../img/pierre.png" alt="" width="25px" style="margin-top: 10px;"/>
                <h1 >Mettre un employee en vacances</h1>		
                <hr style="margin-top: 5px;"> 
		<br>
		<?php
			include_once '../class/employee.class.php';
			Employee::ConsulterEmployee();
		?>
		
			<?php
			}else {
				header('Location: ../indexartisan.php');
			}
			?>

			
			
		</div>
	</body>
</html>